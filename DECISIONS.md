# Engineering Decisions

## Delivery Semantics

I chose **at-least-once delivery**.

This approach prioritizes reliability over avoiding duplicates. If a delivery attempt fails, the system retries. Customer endpoints should therefore be idempotent.

---

## Retry Strategy

Laravel Jobs are configured with:

- Maximum 5 attempts
- Exponential backoff

Failed deliveries are marked as `failed` after all retry attempts are exhausted.

---

## Queue

Laravel Jobs are used to separate request handling from webhook delivery.

For this exercise I used the `sync` queue driver to keep the implementation simple while preserving the same architecture.

In production this could be switched to Redis or another queue backend without changing the application logic.

---

## Architecture

Responsibilities are separated as follows:

- Controller
    - Accept incoming requests
    - Validate input
    - Persist events
    - Dispatch delivery jobs

- Job
    - Coordinate webhook delivery
    - Track retry attempts
    - Update delivery status

- Service
    - Execute HTTP requests
    - Return delivery result

---

## Trade-offs

Given the recommended time budget, I focused on implementing a clean and maintainable architecture instead of production-scale infrastructure.

Potential future improvements include:

- Dead-letter queue
- Event deduplication
- Authentication/signature verification
- Delivery history
- Metrics and monitoring
