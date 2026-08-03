<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
// use Illuminate\Support\Facades\Log;

class AiController extends Controller
{
    public function generateDescription(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string',
            'price' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'category' => 'nullable|string',
            'brand' => 'nullable|string',
            'language' => 'nullable|string',
            'tone' => 'nullable|string',
            'target_audience' => 'nullable|string'
        ]);

        $productName = $request->product_name;
        $price = $request->price;
        $discount = $request->discount;
        $category = $request->category;
        $brand = $request->brand;
        $language = $request->language ?? 'English';
        $tone = $request->tone ?? 'Professional';
        $audience = $request->target_audience;

        // Pricing context
        $priceInfo = "";
        if ($price) {
            $finalPrice = $price - ($discount ?? 0);
            $priceInfo = "Price: {$finalPrice} (Original: {$price}";
            if ($discount > 0) {
                $priceInfo .= ", Discount: {$discount}";
            }
            $priceInfo .= ")";
        }

        // Build a highly optimized marketing prompt requesting structured JSON
        $prompt = "As an expert copywriter and SEO specialist, write a premium marketing product description and metadata for: '{$productName}'.
CRITICAL INSTRUCTION: You MUST write the ENTIRE response (all JSON values) in {$language} language. Do not use English unless the brand name requires it.
Tone: {$tone}
Category: {$category}
Brand: {$brand}
{$priceInfo}
Target Audience: {$audience}

You MUST return a valid JSON object. Do not include any markdown formatting wrappers or text other than the JSON object itself.
Use this JSON schema:
{
  \"short_description\": \"Catchy punchy summary (max 150 characters)\",
  \"description\": \"Comprehensive premium description containing a headline, benefits, features, target users, and Call To Action.\",
  \"meta_title\": \"SEO Meta Title (max 60 characters)\",
  \"meta_description\": \"SEO Meta Description (max 160 characters)\",
  \"meta_keywords\": \"SEO Meta Keywords (comma separated list)\",
  \"tags\": \"Relevant tags (comma separated list, e.g. organic, cotton, premium)\",
  \"certifications\": \"Relevant certifications if applicable (comma separated list, e.g. Organic, ISO, Halal)\",
  \"material\": \"Material or fabric details if fashion (e.g. 100% Cotton)\",
  \"warranty_info\": \"Warranty info if gadget (e.g. 1 Year Brand Warranty)\",
  \"ingredients\": \"Ingredients list if natural/food/cosmetic product\",
  \"usage_instructions\": \"Usage instructions\",
  \"care_instructions\": \"Care/maintenance instructions if fashion\"
}";

        $activeProvider = setting('api_active_provider', 'gemini');
        $apiKey = null;
        $model = null;
        $url = null;
        $apiName = null;
        $postData = [];
        $headers = ['Content-Type' => 'application/json'];

        // Use configured active provider, or fallback to first enabled provider with an API key
        $checkProviders = array_unique(array_merge([$activeProvider], ['gemini', 'groq', 'openrouter', 'zai', 'deepseek', 'mistral', 'openai']));
        $selectedProvider = null;

        foreach ($checkProviders as $p) {
            $key = setting("api_{$p}_key");
            $enabled = setting("api_{$p}_enabled");
            if ($p === $activeProvider && $key) {
                $selectedProvider = $p;
                break;
            }
            if ($enabled === '1' && $key && !$selectedProvider) {
                $selectedProvider = $p;
            }
        }

        if (!$selectedProvider) {
            $selectedProvider = $activeProvider;
        }

        $activeProvider = $selectedProvider;
        $apiKey = setting("api_{$activeProvider}_key");
        $model = setting("api_{$activeProvider}_model");

        if (!$apiKey) {
            $fallback = $this->generateFallbackDescription($productName);
            return response()->json([
                'description' => $fallback,
                'error' => "API key for '{$activeProvider}' is not configured in AI Settings. Using fallback description.",
                'note' => 'Configure your AI API key in Admin → Settings → AI Settings to enable AI-generated descriptions.'
            ]);
        }

        if ($activeProvider === 'gemini') {
            if (!$model || $model === 'gemini-2.5-flash' || $model === 'gemini-2.5-flash-lite') {
                $model = 'gemini-2.0-flash';
            }
            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";
            $apiName = 'gemini';

            $postData = [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'maxOutputTokens' => 4096,
                    'temperature' => 0.7,
                    'topP' => 0.95,
                    'topK' => 40,
                    'responseMimeType' => 'application/json'
                ],
                'safetySettings' => [
                    ['category' => 'HARM_CATEGORY_HATE_SPEECH', 'threshold' => 'BLOCK_ONLY_HIGH'],
                    ['category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT', 'threshold' => 'BLOCK_ONLY_HIGH'],
                    ['category' => 'HARM_CATEGORY_HARASSMENT', 'threshold' => 'BLOCK_ONLY_HIGH'],
                    ['category' => 'HARM_CATEGORY_DANGEROUS_CONTENT', 'threshold' => 'BLOCK_ONLY_HIGH'],
                ]
            ];
        } else {
            // Standard OpenAI Chat Completion Compatible Endpoints (Groq, OpenRouter, Z.ai, DeepSeek, Mistral, OpenAI)
            $apiName = $activeProvider;
            $headers['Authorization'] = "Bearer {$apiKey}";

            switch ($activeProvider) {
                case 'groq':
                    $url = 'https://api.groq.com/openai/v1/chat/completions';
                    $model = $model ?: 'llama-3.3-70b-versatile';
                    break;
                case 'openrouter':
                    $url = 'https://openrouter.ai/api/v1/chat/completions';
                    $model = $model ?: 'google/gemini-2.0-flash-lite:free';
                    $headers['HTTP-Referer'] = config('app.url', 'http://localhost');
                    $headers['X-Title'] = config('app.name', 'OS-Ecommerce');
                    break;
                case 'zai':
                    // Z.ai / Zhipu API
                    $url = 'https://open.bigmodel.cn/api/paas/v4/chat/completions';
                    $model = $model ?: 'glm-4-flash';
                    break;
                case 'deepseek':
                    $url = 'https://api.deepseek.com/chat/completions';
                    $model = $model ?: 'deepseek-chat';
                    break;
                case 'mistral':
                    $url = 'https://api.mistral.ai/v1/chat/completions';
                    $model = $model ?: 'mistral-small-latest';
                    break;
                case 'openai':
                default:
                    $url = 'https://api.openai.com/v1/chat/completions';
                    $model = $model ?: 'gpt-4o-mini';
                    break;
            }

            $postData = [
                'model' => $model,
                'messages' => [
                    ['role' => 'system', 'content' => 'You are an expert e-commerce copywriter. You must always return pure valid JSON without markdown formatting wrappers.'],
                    ['role' => 'user', 'content' => $prompt]
                ],
                'temperature' => 0.7,
                'max_tokens' => 4096
            ];

            // Add response_format only for providers that strictly support it
            if (in_array($activeProvider, ['openai', 'groq', 'openrouter'])) {
                $postData['response_format'] = ['type' => 'json_object'];
            }
        }

        if (session()->isStarted()) {
            session_write_close();
        }

        try {
            $response = Http::withHeaders($headers)
                ->withOptions([
                    'verify' => false, // Prevents local SSL issues
                    'timeout' => 90,
                ])
                ->post($url, $postData);

            if ($response->failed()) {
                $errBody = $response->json();
                $errorMessage = $errBody['error']['message']
                    ?? $errBody['message']
                    ?? $errBody['error']
                    ?? $response->body();

                // \Illuminate\Support\Facades\Log::warning("AI generate-description failed [{$apiName} HTTP {$response->status()}]: " . (is_string($errorMessage) ? $errorMessage : json_encode($errorMessage)));

                $fallback = $this->generateFallbackDescription($productName);
                return response()->json([
                    'description' => $fallback,
                    'error' => "AI API call failed ({$apiName}, HTTP {$response->status()}). Using fallback description.",
                    'details' => is_string($errorMessage) ? $errorMessage : json_encode($errorMessage)
                ]);
            }

            $result = $response->json();
            $shortDescription = '';
            $description = null;
            $metaTitle = '';
            $metaDescription = '';
            $metaKeywords = '';
            $tags = '';
            $certifications = '';
            $material = '';
            $warrantyInfo = '';
            $ingredients = '';
            $usageInstructions = '';
            $careInstructions = '';

            $text = null;
            if ($apiName === 'gemini' && isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                $text = trim($result['candidates'][0]['content']['parts'][0]['text']);
            } elseif (isset($result['choices'][0]['message']['content'])) {
                $text = trim($result['choices'][0]['message']['content']);
            }

            if ($text) {
                // Parse JSON response
                $jsonStr = $text;
                if (preg_match('/```json\s*(.*?)\s*```/s', $text, $matches)) {
                    $jsonStr = $matches[1];
                } elseif (preg_match('/```\s*(.*?)\s*```/s', $text, $matches)) {
                    $jsonStr = $matches[1];
                }

                $data = json_decode(trim($jsonStr), true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
                    $shortDescription = $data['short_description'] ?? '';
                    $description = $data['description'] ?? '';
                    $metaTitle = $data['meta_title'] ?? '';
                    $metaDescription = $data['meta_description'] ?? '';
                    $metaKeywords = $data['meta_keywords'] ?? '';
                    $tags = $data['tags'] ?? '';
                    $certifications = $data['certifications'] ?? '';
                    $material = $data['material'] ?? '';
                    $warrantyInfo = $data['warranty_info'] ?? '';
                    $ingredients = $data['ingredients'] ?? '';
                    $usageInstructions = $data['usage_instructions'] ?? '';
                    $careInstructions = $data['care_instructions'] ?? '';
                } else {
                    $description = $text;
                }
            }

            if (!$description) {
                $description = $this->generateFallbackDescription($productName);
            }

            return response()->json([
                'short_description' => $shortDescription,
                'description' => $description,
                'meta_title' => $metaTitle,
                'meta_description' => $metaDescription,
                'meta_keywords' => $metaKeywords,
                'tags' => $tags,
                'certifications' => $certifications,
                'material' => $material,
                'warranty_info' => $warrantyInfo,
                'ingredients' => $ingredients,
                'usage_instructions' => $usageInstructions,
                'care_instructions' => $careInstructions
            ]);
        } catch (\Exception $e) {
            $fallbackDescription = $this->generateFallbackDescription($productName);

            return response()->json([
                'description' => $fallbackDescription,
                'note' => 'AI generation failed, using fallback description'
            ]);
        }
    }

    /**
     * Generate a complete description from partial response
     */
    private function completePartialDescription($partialText, $productName)
    {
        // If we have at least a headline, complete it
        if (str_contains($partialText, 'HEADLINE:')) {
            $lines = explode("\n", $partialText);
            $completed = [];

            $sections = [
                'HEADLINE:' => 'Create a compelling headline',
                'INTRODUCTION:' => 'Add engaging introduction',
                'KEY FEATURES:' => 'List 4-5 key features with benefits',
                'SPECIFICATIONS:' => 'Add relevant specifications',
                'TARGET USERS:' => 'Describe ideal customers',
                'CALL TO ACTION:' => 'Add persuasive call to action'
            ];

            foreach ($sections as $section => $default) {
                $found = false;
                foreach ($lines as $line) {
                    if (str_starts_with(trim($line), $section)) {
                        $completed[] = $line;
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $completed[] = $section . ' ' . $default . " for {$productName}.";
                }
            }

            return implode("\n\n", $completed);
        }

        return $this->generateFallbackDescription($productName);
    }

    /**
     * Generate a fallback description
     */
    private function generateFallbackDescription($productName)
    {
        $templates = [
            "Introducing the revolutionary {$productName} - where innovation meets excellence. Designed for professionals who demand the best, this premium product combines cutting-edge technology with user-centric design.

KEY FEATURES:
• Advanced performance that delivers exceptional results
• Durable construction for long-lasting reliability
• Intuitive interface for effortless operation
• Energy-efficient design to reduce costs
• Versatile functionality for multiple applications

SPECIFICATIONS:
• High-quality materials and craftsmanship
• Multiple configuration options available
• Industry-standard compatibility
• Comprehensive warranty included

PERFECT FOR:
• Professionals seeking enhanced productivity
• Businesses looking to streamline operations
• Enthusiasts who value quality and performance
• Anyone wanting reliable, top-tier results

Elevate your experience today with the {$productName} - your solution for unmatched quality and performance. Order now and transform the way you work!",

            "Discover the exceptional {$productName}, engineered to deliver outstanding performance and reliability. With its sophisticated design and innovative features, this product sets a new standard in its category.

MAIN BENEFITS:
• Increases efficiency and saves valuable time
• Reduces operational costs with smart design
• Enhances results with precision engineering
• Simplifies complex tasks with user-friendly controls
• Built to last with premium materials

TECHNICAL HIGHLIGHTS:
• Robust construction for demanding environments
• Advanced safety features for peace of mind
• Easy maintenance and service access
• Compatible with industry standards

IDEAL FOR:
• Professional users who demand reliability
• Businesses focused on quality and value
• Technical users who appreciate innovation
• Anyone seeking superior performance

Take the next step in excellence - choose the {$productName} for results that speak for themselves. Available now for immediate delivery!"
        ];

        return $templates[array_rand($templates)];
    }

    /**
     * Try to complete a very short response
     */
    private function generateCompleteDescription($productName, $partialResponse)
    {
        if (strlen($partialResponse) < 50) {
            return $this->generateFallbackDescription($productName);
        }

        // If we got at least a headline, build on it
        $description = $partialResponse . "\n\n";

        $description .= "INTRODUCTION: Experience unparalleled performance and innovation with the {$productName}. Designed to exceed expectations, this premium product delivers exceptional value and results.\n\n";

        $description .= "KEY FEATURES:\n";
        $description .= "• Cutting-edge technology for superior performance\n";
        $description .= "• Robust construction for long-lasting durability\n";
        $description .= "• User-friendly design for effortless operation\n";
        $description .= "• Energy-efficient operation to reduce costs\n";
        $description .= "• Versatile applications for various needs\n\n";

        $description .= "SPECIFICATIONS:\n";
        $description .= "• Premium materials and expert craftsmanship\n";
        $description .= "• Industry-leading quality standards\n";
        $description .= "• Multiple configuration options\n";
        $description .= "• Comprehensive support and warranty\n\n";

        $description .= "TARGET AUDIENCE:\n";
        $description .= "• Professionals seeking reliable performance\n";
        $description .= "• Businesses wanting to enhance productivity\n";
        $description .= "• Technical users who value innovation\n";
        $description .= "• Anyone demanding quality and results\n\n";

        $description .= "CALL TO ACTION: Don't settle for ordinary - choose excellence with the {$productName}. Order today and experience the difference premium quality makes!";

        return $description;
    }
}
