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
            'product_name' => 'required|string'
        ]);

        $productName = $request->product_name;

        // More concise and clear prompt
        $prompt = "As a professional e-commerce copywriter, write a complete product description for: '{$productName}'
    
    Structure:
    1. HEADLINE: Catchy title (5-8 words)
    2. INTRODUCTION: 2-3 engaging sentences about main benefits
    3. KEY FEATURES: 4-5 bullet points (each: feature + benefit)
    4. SPECIFICATIONS: Key technical details
    5. TARGET USERS: Who should buy this
    6. CALL TO ACTION: Persuasive ending
    
    Important: Return ALL 6 sections. Write 250-300 words total. Use plain text with clear section breaks.";

        $apiKey = null;
        $model = null;
        $url = null;
        $apiName = null;
        $postData = [];

        if (setting('api_gemini_enabled') === '1') {
            $apiKey = setting('api_gemini_key');
            $model = setting('api_gemini_model', 'gemini-1.5-flash');

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
                    'maxOutputTokens' => 1500, // Increased for full response
                    'temperature' => 0.8,
                    'topP' => 0.95,
                    'topK' => 40,
                ],
                'safetySettings' => [
                    ['category' => 'HARM_CATEGORY_HATE_SPEECH', 'threshold' => 'BLOCK_ONLY_HIGH'],
                    ['category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT', 'threshold' => 'BLOCK_ONLY_HIGH'],
                    ['category' => 'HARM_CATEGORY_HARASSMENT', 'threshold' => 'BLOCK_ONLY_HIGH'],
                    ['category' => 'HARM_CATEGORY_DANGEROUS_CONTENT', 'threshold' => 'BLOCK_ONLY_HIGH'],
                ]
            ];
        } else {
            return response()->json(['error' => 'No API is enabled in settings'], 500);
        }

        if (!$apiKey) {
            // Log::error('Gemini API key is not configured.');
            return response()->json(['error' => 'Gemini API key is not configured.'], 500);
        }

        try {
            $response = Http::withHeaders(['Content-Type' => 'application/json'])
                ->withOptions([
                    'verify' => !app()->environment('local'),
                    'timeout' => 90, // Increased timeout
                ])
                ->post($url, $postData);

            if ($response->failed()) {
                // Log::error('API request failed', [
                //     'status' => $response->status(),
                //     'response' => $response->body()
                // ]);

                return response()->json([
                    'error' => 'API call failed',
                    'details' => $response->json()['error']['message'] ?? 'Unknown error'
                ], $response->status());
            }

            $result = $response->json();

            // Debug log
            // Log::info('API Response', [
            //     'has_candidates' => isset($result['candidates']),
            //     'candidate_count' => isset($result['candidates']) ? count($result['candidates']) : 0,
            //     'finish_reason' => $result['candidates'][0]['finishReason'] ?? 'none',
            //     'response_keys' => array_keys($result)
            // ]);
            $description = null;

            if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                $description = trim($result['candidates'][0]['content']['parts'][0]['text']);

                // Check if response is complete
                if (strlen($description) < 100) {
                    // Log::warning('Response seems too short', ['length' => strlen($description)]);
                    // Try to generate a fallback
                    $description = $this->generateCompleteDescription($productName, $description);
                }

            } elseif (isset($result['candidates'][0]['finishReason'])) {
                $finishReason = $result['candidates'][0]['finishReason'];

                if ($finishReason === 'MAX_TOKENS') {
                    // Extract whatever text we got
                    if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                        $partialText = trim($result['candidates'][0]['content']['parts'][0]['text']);
                        $description = $this->completePartialDescription($partialText, $productName);
                    }
                } elseif ($finishReason === 'SAFETY') {
                    return response()->json(['error' => 'Content was blocked by safety filters.'], 400);
                }
            }

            if (!$description) {
                // Generate a fallback description
                $description = $this->generateFallbackDescription($productName);
            }

            // Log::info('AI Description Generated', [
            //     'product_name' => $productName,
            //     'api' => $apiName,
            //     'model' => $model,
            //     'description_length' => strlen($description)
            // ]);

            return response()->json(['description' => $description]);

        } catch (\Exception $e) {
            // Log::error('AI Description Generation Failed: ' . $e->getMessage());

            // Generate fallback on exception
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
