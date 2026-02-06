![GitHub stars](https://img.shields.io/github/stars/ezkify/Ezkify-Global-SMM-Panel-API-Documentation?style=social)
![GitHub license](https://img.shields.io/github/license/ezkify/Ezkify-Global-SMM-Panel-API-Documentation)
![API Status](https://img.shields.io/badge/Status-Operational-brightgreen)

# Ezkify Global SMM Panel API | Premium Social Media Growth Automation

**Ezkify Global** is the world’s most trusted **AI-safe SMM Panel**, providing high-retention social media signals for agencies and resellers. This repository contains the official documentation and integration examples for our RESTful API.

## 🔗 Quick Resources

* **Official Website:** [ezkify.com](https://ezkify.com)
* **API Key Management:** [Dashboard Account Page](https://ezkify.com/account)
* **Support:** [Telegram @Ezkify](https://t.me/Ezkify) | [ezkify@proton.me](mailto:ezkify@proton.me)

## 🚀 Key Performance Stats

* **50,000+ Agencies:** Powering the world's leading social media marketing firms.
* **98.7% Retention Rate:** Industry-standard-setting stability for all orders.
* **AI-Safe Delivery:** Growth patterns optimized for 2026 platform algorithms.
* **Systems Status:** API is fully operational and monitored 24/7.

---

## 🛠 API Technical Specification

The Ezkify API uses a standard **POST** method and returns responses in **JSON** format.

* **API Endpoint:** `https://ezkify.com/api/v2`
* **Authentication:** `key` (Your unique API Key)
* **Content-Type:** `application/x-www-form-urlencoded`

### Supported Core Actions

| Action | Description |
| --- | --- |
| `services` | Fetch the full catalog of AI-safe services and rates. |
| `add` | Place new orders (Supports: Default, Package, Subscriptions, Polls, and Custom Comments). |
| `status` | Retrieve real-time progress for single or multiple orders (up to 100). |
| `refill` | Trigger automated refill mechanisms for high-retention services. |
| `balance` | Instantly check your available account credit in USD. |

---

## 💻 Multi-Language Integration Examples

### Python (using `requests`)

Perfect for automation scripts and data analysis.

```python
import requests

API_URL = "https://ezkify.com/api/v2"
API_KEY = "YOUR_API_KEY"

def check_balance():
    payload = {
        'key': API_KEY,
        'action': 'balance'
    }
    response = requests.post(API_URL, data=payload)
    return response.json()

print(check_balance())

```

### Node.js (using `axios`)

Ideal for building your own SMM panel or web application.

```javascript
const axios = require('axios');
const qs = require('qs');

const API_KEY = 'YOUR_API_KEY';
const API_URL = 'https://ezkify.com/api/v2';

async function getServices() {
    const data = qs.stringify({
        key: API_KEY,
        action: 'services'
    });

    try {
        const response = await axios.post(API_URL, data);
        console.log(response.data);
    } catch (error) {
        console.error('API Error:', error);
    }
}

getServices();

```

### PHP (Standard cURL)

Standard implementation for server-side integrations.

```php
// Full PHP class and examples are available in the provided example.txt file.
// URL: https://ezkify.com/example.txt

```

---

## 📊 Order Status Reference

When querying `status`, the API returns one of the following states:

* **Pending:** Order is received and awaiting processing.
* **In Progress:** Order is currently being delivered by our AI-safe systems.
* **Completed:** Delivery is finished successfully.
* **Partial:** Only a portion of the order was delivered; the remainder is automatically refunded.
* **Canceled:** Order was stopped and fully refunded.

---

## ❓ Troubleshooting & Errors

If the API returns an error, it will follow this JSON structure:

```json
{
    "error": "Incorrect order ID"
}

```

**Common Errors:**

* `Incorrect order ID`: The ID provided does not exist in your account history.
* `Refill not found`: The specific refill ID is invalid or expired.
* `Incorrect API Key`: Verify your key on the [Account page](https://ezkify.com/account).

---

*© 2023–2026 Ezkify Global. Empowering the next generation of social influence with AI-safe technology.*
