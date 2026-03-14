# tina4php-shopify

A Shopify app starter built on the Tina4 PHP framework. Handles OAuth authentication, session management, webhook registration, and provides a foundation for building embedded Shopify apps.

## Features

- Full Shopify OAuth flow (install, callback, token storage)
- Database-backed session and cookie storage using Tina4 ORM
- Automatic webhook registration and processing for common Shopify events
- Generic webhook handler with per-topic dispatch
- Twig-based admin templates
- Built on the official `shopify/shopify-api` PHP SDK

## Requirements

- PHP >= 8.1
- [tina4php](https://github.com/tina4stack/tina4-php) ^2.0
- [tina4php-sqlite3](https://github.com/tina4stack/tina4php-sqlite3) ^2.0
- [shopify/shopify-api](https://github.com/Shopify/shopify-api-php) ^5.0
- A [Shopify Partners](https://partners.shopify.com/organizations) account

## Installing

```bash
composer install
npm install
```

## Setup

1. Register an app at [Shopify Partners](https://partners.shopify.com/organizations).

2. Create a `.env` file with your Shopify credentials:

```
SHOPIFY_API_KEY=your_api_key
SHOPIFY_API_SECRET=your_api_secret
SHOPIFY_APP_SCOPES=read_products,write_products
SHOPIFY_APP_HOST_NAME=your-app-hostname.com
```

3. Start the application and run migrations:

```bash
composer start
```

4. Browse to `http://localhost:7118/migrate` to initialize the database.

5. Stop the app, then deploy with:

```bash
npm run dev
```

6. Follow the on-screen prompts to configure your Shopify app, then copy the URL, API Key, and Secret into your `.env` file.

## Architecture

### Routes

| Route | Method | Description |
|-------|--------|-------------|
| `/` | GET | App entry point, redirects to OAuth if coming from Shopify Partners |
| `/login` | GET | Initiates Shopify OAuth flow |
| `/auth/callback` | GET | Handles OAuth callback, stores session, registers webhooks |
| `/settings` | GET | App settings page |
| `/shopify/webhooks` | POST | Receives and processes Shopify webhooks |

### Key Classes

| Class | Description |
|-------|-------------|
| `ShopifyHelper` | Registers webhook handlers, retrieves session data, manages shop removal |
| `AuthHelper` | Extends `Tina4\Auth`, delegates token validation to Shopify |
| `SessionHelper` | Implements `Shopify\Auth\SessionStorage` with database persistence |
| `GenericHandler` | Implements `Shopify\Webhooks\Handler` with topic-based dispatch |

### Registered Webhooks

The app listens for the following Shopify webhook topics by default:

- `APP_UNINSTALLED` -- cleans up session and cookie data
- `CARTS_CREATE`
- `CARTS_UPDATE`
- `ORDERS_CREATE`
- `ORDERS_UPDATED`
- `ORDERS_CANCELLED`

Add custom handling in `GenericHandler::handle()` by extending the switch statement.

### ORM Objects

| Object | Table | Description |
|--------|-------|-------------|
| `Session` | `session` | Stores Shopify session data (shop, session ID, JSON payload) |
| `Cookie` | `cookie` | Stores OAuth cookies per shop |

## License

MIT -- see [LICENSE](LICENSE) for details.

---

## Our Sponsors

**Sponsored with 🩵 by Code Infinity**

[<img src="https://codeinfinity.co.za/wp-content/uploads/2025/09/c8e-logo-github.png" alt="Code Infinity" width="100">](https://codeinfinity.co.za/about-open-source-policy?utm_source=github&utm_medium=website&utm_campaign=opensource_campaign&utm_id=opensource)

*Supporting open source communities <span style="color: #1DC7DE;">•</span> Innovate <span style="color: #1DC7DE;">•</span> Code <span style="color: #1DC7DE;">•</span> Empower*
