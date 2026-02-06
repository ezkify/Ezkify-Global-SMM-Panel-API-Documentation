<?php
/**
 * Ezkify Global SMM Panel API Integration Class
 * 
 * Official PHP wrapper for Ezkify Global API - Premium AI-Safe SMM Panel
 * 
 * @version 2.0
 * @author Ezkify Global
 * @link https://ezkify.com
 * @license MIT
 * 
 * Features:
 * - Place orders for 1000+ social media services
 * - Check order status (single & batch)
 * - Auto-refill system integration
 * - Cancel orders
 * - Fetch real-time service catalog
 * - Check account balance
 * 
 * Retention Rate: 98.7% | Trusted by 50,000+ Agencies
 */

class EzkifyApi
{
    /** API URL */
    public $api_url = 'https://ezkify.com/api/v2';

    /** Your API key */
    public $api_key = '';

    /**
     * Constructor
     * 
     * @param string $api_key Your Ezkify API key
     * @param string $api_url API endpoint (default: https://ezkify.com/api/v2)
     */
    public function __construct($api_key = '', $api_url = 'https://ezkify.com/api/v2')
    {
        $this->api_key = $api_key;
        $this->api_url = $api_url;
    }

    /**
     * Place a new order
     * 
     * @param array $data Order parameters (service, link, quantity, etc.)
     * @return object Order response with order ID
     */
    public function order($data)
    {
        $post = array_merge(['key' => $this->api_key, 'action' => 'add'], $data);
        return json_decode((string)$this->connect($post));
    }

    /**
     * Get single order status
     * 
     * @param int $order_id Order ID
     * @return object Order status, remains, start count, charge
     */
    public function status($order_id)
    {
        return json_decode(
            $this->connect([
                'key' => $this->api_key,
                'action' => 'status',
                'order' => $order_id
            ])
        );
    }

    /**
     * Get multiple orders status (batch up to 100)
     * 
     * @param array $order_ids Array of order IDs
     * @return object Orders status array
     */
    public function multiStatus($order_ids)
    {
        return json_decode(
            $this->connect([
                'key' => $this->api_key,
                'action' => 'status',
                'orders' => implode(",", (array)$order_ids)
            ])
        );
    }

    /**
     * Get all available services with pricing
     * 
     * @return array Array of service objects
     */
    public function services()
    {
        return json_decode(
            $this->connect([
                'key' => $this->api_key,
                'action' => 'services',
            ])
        );
    }

    /**
     * Request refill for a single order
     * 
     * @param int $orderId Order ID to refill
     * @return object Refill response with refill ID
     */
    public function refill(int $orderId)
    {
        return json_decode(
            $this->connect([
                'key' => $this->api_key,
                'action' => 'refill',
                'order' => $orderId,
            ])
        );
    }

    /**
     * Request refill for multiple orders
     * 
     * @param array $orderIds Array of order IDs
     * @return array Refill responses
     */
    public function multiRefill(array $orderIds)
    {
        return json_decode(
            $this->connect([
                'key' => $this->api_key,
                'action' => 'refill',
                'orders' => implode(',', $orderIds),
            ]),
            true,
        );
    }

    /**
     * Get refill status for single refill
     * 
     * @param int $refillId Refill ID
     * @return object Refill status
     */
    public function refillStatus(int $refillId)
    {
         return json_decode(
            $this->connect([
                'key' => $this->api_key,
                'action' => 'refill_status',
                'refill' => $refillId,
            ])
        );
    }

    /**
     * Get refill statuses for multiple refills
     * 
     * @param array $refillIds Array of refill IDs
     * @return array Refill statuses
     */
    public function multiRefillStatus(array $refillIds)
    {
         return json_decode(
            $this->connect([
                'key' => $this->api_key,
                'action' => 'refill_status',
                'refills' => implode(',', $refillIds),
            ]),
            true,
        );
    }

    /**
     * Cancel multiple orders
     * 
     * @param array $orderIds Array of order IDs to cancel
     * @return array Cancellation results
     */
    public function cancel(array $orderIds)
    {
        return json_decode(
            $this->connect([
                'key' => $this->api_key,
                'action' => 'cancel',
                'orders' => implode(',', $orderIds),
            ]),
            true,
        );
    }

    /**
     * Get account balance
     * 
     * @return object Balance and currency
     */
    public function balance()
    {
        return json_decode(
            $this->connect([
                'key' => $this->api_key,
                'action' => 'balance',
            ])
        );
    }

    /**
     * Internal cURL connection handler
     * 
     * @param array $post POST data
     * @return string|false API response or false on error
     */
    private function connect($post)
    {
        $_post = [];
        if (is_array($post)) {
            foreach ($post as $name => $value) {
                $_post[] = $name . '=' . urlencode($value);
            }
        }

        $ch = curl_init($this->api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        if (is_array($post)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, join('&', $_post));
        }
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        $result = curl_exec($ch);
        
        if (curl_errno($ch) != 0 && empty($result)) {
            $result = false;
        }
        
        curl_close($ch);
        return $result;
    }
}

// ============================================================================
// USAGE EXAMPLES
// ============================================================================

// Initialize API
$api = new EzkifyApi('YOUR_API_KEY_HERE');

// ============================================================================
// 1. Get Account Balance
// ============================================================================
echo "=== ACCOUNT BALANCE ===\n";
$balance = $api->balance();
if ($balance && isset($balance->balance)) {
    echo "Balance: $" . $balance->balance . " " . $balance->currency . "\n\n";
}

// ============================================================================
// 2. Fetch All Services
// ============================================================================
echo "=== AVAILABLE SERVICES ===\n";
$services = $api->services();
if (is_array($services)) {
    echo "Total Services: " . count($services) . "\n";
    // Show first 5 services
    foreach (array_slice($services, 0, 5) as $service) {
        echo "- {$service->name} (ID: {$service->service}) - \${$service->rate}/1000\n";
    }
    echo "...\n\n";
}

// ============================================================================
// 3. Place Orders - Different Types
// ============================================================================

echo "=== PLACING ORDERS ===\n";

// Standard order (followers, likes, views)
$order1 = $api->order([
    'service' => 1,              // Service ID from services list
    'link' => 'https://instagram.com/yourprofile',
    'quantity' => 1000
]);
echo "Standard Order ID: " . ($order1->order ?? 'Failed') . "\n";

// Custom comments order
$order2 = $api->order([
    'service' => 1,
    'link' => 'https://instagram.com/p/POST_ID',
    'comments' => "Great post!\nLove this!\nAmazing content\n🔥"
]);
echo "Comments Order ID: " . ($order2->order ?? 'Failed') . "\n";

// Package order (auto-quantity)
$order3 = $api->order([
    'service' => 1,
    'link' => 'https://instagram.com/yourprofile'
]);
echo "Package Order ID: " . ($order3->order ?? 'Failed') . "\n";

// Subscription order - Old posts only
$order4 = $api->order([
    'service' => 1,
    'username' => 'yourusername',
    'min' => 100,
    'max' => 110,
    'posts' => 0,
    'delay' => 30,
    'expiry' => '12/31/2026'
]);
echo "Subscription Order ID: " . ($order4->order ?? 'Failed') . "\n";

// Poll order
$order5 = $api->order([
    'service' => 1,
    'link' => 'https://instagram.com/p/POLL_POST',
    'quantity' => 100,
    'answer_number' => '7'
]);
echo "Poll Order ID: " . ($order5->order ?? 'Failed') . "\n\n";

// ============================================================================
// 4. Check Order Status
// ============================================================================

echo "=== CHECKING ORDER STATUS ===\n";
if (isset($order1->order)) {
    $status = $api->status($order1->order);
    if ($status) {
        echo "Order {$order1->order} Status:\n";
        echo "- Status: " . ($status->status ?? 'N/A') . "\n";
        echo "- Remains: " . ($status->remains ?? 'N/A') . "\n";
        echo "- Start Count: " . ($status->start_count ?? 'N/A') . "\n";
        echo "- Charge: $" . ($status->charge ?? 'N/A') . "\n\n";
    }
}

// ============================================================================
// 5. Batch Check Multiple Orders
// ============================================================================

echo "=== BATCH ORDER STATUS ===\n";
$orderIds = [
    $order1->order ?? 1,
    $order2->order ?? 2,
    $order3->order ?? 3
];
$statuses = $api->multiStatus($orderIds);
if (is_object($statuses)) {
    foreach ($statuses as $orderId => $status) {
        echo "Order $orderId: " . ($status->status ?? 'N/A') . " (Remains: " . ($status->remains ?? 'N/A') . ")\n";
    }
}
echo "\n";

// ============================================================================
// 6. Request Refill for Partial Orders
// ============================================================================

echo "=== REQUESTING REFILLS ===\n";
$refillResponse = (array) $api->multiRefill($orderIds);
$refillIds = array_column($refillResponse, 'refill');
echo "Refill IDs: " . implode(', ', $refillIds) . "\n\n";

// ============================================================================
// 7. Check Refill Status
// ============================================================================

if (!empty($refillIds)) {
    echo "=== REFILL STATUSES ===\n";
    $refillStatuses = $api->multiRefillStatus($refillIds);
    if (is_array($refillStatuses)) {
        foreach ($refillStatuses as $refillId => $status) {
            echo "Refill $refillId: " . ($status->status ?? 'N/A') . "\n";
        }
    }
    echo "\n";
}

// ============================================================================
// 8. Cancel Orders (if needed)
// ============================================================================

// Uncomment to cancel orders
// $cancelResult = $api->cancel([$order1->order, $order2->order]);
// echo "Cancellation Result: " . print_r($cancelResult, true) . "\n";

// ============================================================================
// TROUBLESHOOTING & ERROR HANDLING
// ============================================================================

/**
 * Common Error Responses:
 * 
 * {"error": "Invalid API key"} - Check your API key in dashboard
 * {"error": "Invalid service"} - Service ID doesn't exist, fetch services first
 * {"error": "Insufficient balance"} - Top up your account
 * {"error": "Invalid link"} - URL format is incorrect
 * {"error": "Quantity less than minimum"} - Check service min requirements
 * {"error": "Quantity more than maximum"} - Check service max limits
 * 
 * Support:
 * - Telegram: @Ezkify
 * - Email: ezkify@proton.me
 * - Dashboard: https://ezkify.com/account
 */

// ============================================================================
// ADVANCED: Loop Through Services to Find Specific Ones
// ============================================================================

function findServiceByName($services, $searchTerm) {
    foreach ($services as $service) {
        if (stripos($service->name, $searchTerm) !== false) {
            return $service;
        }
    }
    return null;
}

// Example: Find Instagram Followers service
$igFollowers = findServiceByName($services, 'followers');
if ($igFollowers) {
    echo "Found Instagram Followers:\n";
    echo "- Service ID: {$igFollowers->service}\n";
    echo "- Rate: \${$igFollowers->rate}/1000\n";
    echo "- Min: {$igFollowers->min} | Max: {$igFollowers->max}\n";
}

echo "\n=== END OF EXAMPLES ===\n";
echo "\nFor full documentation, visit: https://ezkify.com\n";
echo "Need help? Contact us: Telegram @Ezkify | ezkify@proton.me\n";
?>
