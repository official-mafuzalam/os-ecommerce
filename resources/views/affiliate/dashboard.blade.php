<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affiliate Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; margin: 0; padding: 2rem; }
        .container { background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); max-width: 800px; margin: 0 auto; }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee; padding-bottom: 1rem; margin-bottom: 1rem; }
        .stats { display: flex; gap: 1rem; margin-bottom: 2rem; }
        .stat-card { background: #f8f9fa; padding: 1rem; border-radius: 4px; flex: 1; text-align: center; border: 1px solid #ddd; }
        .stat-card h3 { margin: 0 0 .5rem 0; font-size: 1.5rem; color: #333; }
        .stat-card p { margin: 0; color: #666; font-size: .875rem; text-transform: uppercase; }
        .referral-link { background: #e9ecef; padding: 1rem; border-radius: 4px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .referral-link input { flex: 1; padding: .5rem; border: 1px solid #ccc; border-radius: 4px; margin-right: 1rem; }
        .referral-link button { padding: .5rem 1rem; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { padding: .75rem; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f9fa; }
        .badge { padding: .25rem .5rem; border-radius: 999px; font-size: .75rem; font-weight: bold; }
        .badge.pending { background: #ffeeba; color: #856404; }
        .badge.approved { background: #d4edda; color: #155724; }
        .badge.cancelled { background: #f8d7da; color: #721c24; }
        .logout-btn { background: #dc3545; color: white; padding: .5rem 1rem; border: none; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Welcome, {{ $affiliate->name }}</h2>
            <form action="{{ route('affiliate.logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>

        @if (!setting('affiliate_marketing_status', true))
            <div style="background-color: #fff3cd; color: #856404; padding: 1rem; border: 1px solid #ffeeba; border-radius: 4px; margin-bottom: 1.5rem; text-align: center; font-weight: bold;">
                ⚠️ Affiliate Marketing System is currently disabled by the administration.
            </div>
        @endif

        <div class="stats">
            <div class="stat-card">
                <h3>৳{{ number_format($totalEarnings, 2) }}</h3>
                <p>Approved Earnings</p>
            </div>
            <div class="stat-card">
                <h3>৳{{ number_format($pendingEarnings, 2) }}</h3>
                <p>Pending Earnings</p>
            </div>
        </div>

        <div>
            <h4>Your Referral Link</h4>
            <div class="referral-link">
                <input type="text" id="refLink" value="{{ $affiliate->referral_link }}" readonly>
                <button onclick="copyLink()">Copy Link</button>
            </div>
        </div>

        <div>
            <h4>Recent Referrals</h4>
            <table>
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($earnings as $earning)
                        <tr>
                            <td>{{ $earning->order->order_number ?? 'N/A' }}</td>
                            <td>৳{{ number_format($earning->amount, 2) }}</td>
                            <td>
                                <span class="badge {{ strtolower($earning->status) }}">
                                    {{ ucfirst($earning->status) }}
                                </span>
                            </td>
                            <td>{{ $earning->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: #666;">No referrals yet. Share your link to start earning!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function copyLink() {
            var copyText = document.getElementById("refLink");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            document.execCommand("copy");
            alert("Copied the link: " + copyText.value);
        }
    </script>
</body>
</html>
