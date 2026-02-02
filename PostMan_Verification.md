# Postman Verification Guide: Security & Performance

This document outlines the step-by-step procedures to verify the security controls of the IceMacha-v2 API using Postman.

## 1. Access Control (Sanctum Token Abilities)
**Objective:** Verify that specific roles (Admin vs User) receive different token scopes and access privileges.

### Test A: Login & Token Inspection
1.  **Method:** `POST`
2.  **URL:** `{{base_url}}/api/login`
3.  **Body (JSON):**
    ```json
    {
        "email": "admin_proof@example.com",
        "password": "password",
        "device_name": "Postman_Test"
    }
    ```
4.  **Verification:**
    *   Inspect the Response Body.
    *   **Check:** `abilities` array should contain `["admin:all"]`.
    *   *Repeat with a standard user to see `["products:read", "cart:write"]`.*

### Test B: Unauthorized Access Enforcement
1.  **Method:** `POST`
2.  **URL:** `{{base_url}}/api/products` (Create Product - Admin Only)
3.  **Headers:**
    *   `Authorization`: `Bearer {{user_token}}` (Use a **Standard User** token)
    *   `Accept`: `application/json`
4.  **Verification:**
    *   **Expected Status:** `403 Forbidden`
    *   **Response:** `{"message": "Invalid ability provided."}` or similar denial message.

---

## 2. Mass Assignment Protection
**Objective:** Verify that users cannot modify protected fields (e.g., `role`, `wallet_balance`) by injecting them into the request.

### Test Case
1.  **Method:** `POST`
2.  **URL:** `{{base_url}}/api/register` (or Update Profile endpoint)
3.  **Body (JSON):**
    ```json
    {
        "name": "Hacker",
        "email": "hacker@example.com",
        "password": "password",
        "password_confirmation": "password",
        "role": "admin"  <-- Malicious injection
    }
    ```
4.  **Verification:**
    *   **Expected Behavior:** Account is created, but `role` remains `user` (default) in the database.
    *   **Check DB:** `SELECT role FROM users WHERE email='hacker@example.com';` -> Should be `user`.

---

## 3. SQL Injection Mitigation
**Objective:** Confirm that Eloquent handles malicious SQL payloads safely.

### Test Case
1.  **Method:** `GET`
2.  **URL:** `{{base_url}}/api/v1/products/' OR 1=1 --`
3.  **Verification:**
    *   **Expected Status:** `404 Not Found` (Eloquent `findOrFail` treats the entire string as an ID).
    *   **Failure Condition:** If the API returns **all** products or a database syntax error dump, the test fails.

---

## 4. API Rate Limiting
**Objective:** Ensure the API blocks excessive requests to prevent DoS.

### Test Case
1.  **Method:** `GET`
2.  **URL:** `{{base_url}}/api/v1/products`
3.  **Action:** Send this request rapid-fire (e.g., using Postman "Runner" or "Collection Run").
4.  **Configuration:** 65 iterations with 0ms delay.
5.  **Verification:**
    *   **Requests 1-60:** `200 OK`
    *   **Request 61+:** `429 Too Many Requests`

---

## 5. XSS Protection (Stored)
**Objective:** Verify that Blade sanitizes stored script tags.

### Test Case
1.  **Method:** `POST` (As Admin)
2.  **URL:** `{{base_url}}/api/products`
3.  **Body (JSON):**
    ```json
    {
        "name": "XSS Product",
        "description": "<script>alert('XSS')</script>",
        "price": 100,
        "category_id": 1,
        "stock_quantity": 10
    }
    ```
4.  **Action:** View the product on the Frontend (Browser).
5.  **Verification:**
    *   **Expected:** The browser displays the text `<script>alert('XSS')</script>` literally.
    *   **Failure:** An alert box pops up (Script executed).

---

## 6. HTTPS Enforcement
**Objective:** Confirm insecure HTTP requests are upgraded or rejected.

### Test Case
1.  **Method:** `GET`
2.  **URL:** `http://your-production-domain.com/api/v1/products` (Note: `http` protocol)
3.  **Verification:**
    *   **Expected:** `301 Moved Permanently` (Redirect to HTTPS) or connection upgrade.
    *   *Note: This only works on the Production environment, as local dev usually runs on HTTP.*
