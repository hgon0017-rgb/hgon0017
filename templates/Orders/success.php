<?php
/**
 * templates/Orders/success.php
 * Order confirmation page with progress animation
 * @var \App\Model\Entity\Order $order
 */
?>
<style>
    body {
        background: #f9fafb;
        font-family: Arial, sans-serif;
    }

    .confirmation-container {
        max-width: 600px;
        margin: 80px auto;
        background: #fff;
        border-radius: 14px;
        padding: 40px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .progress-bar-wrap {
        width: 100%;
        height: 10px;
        background: #e5e7eb;
        border-radius: 999px;
        overflow: hidden;
        margin-bottom: 30px;
    }

    .progress-bar {
        width: 0%;
        height: 100%;
        background: linear-gradient(90deg, #4f46e5, #6366f1);
        border-radius: 999px;
        transition: width 1.2s ease-in-out;
    }

    .hidden {
        display: none;
    }

    .confirmation-title {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 10px;
        color: #111827;
    }

    .confirmation-msg {
        color: #374151;
        margin-bottom: 25px;
    }

    .summary-line {
        display: flex;
        justify-content: space-between;
        margin: 8px 0;
        font-size: 16px;
    }

    .summary-total {
        font-weight: 700;
        font-size: 18px;
    }
</style>

<div class="confirmation-container">
    <!-- Step 1: Progress bar -->
    <div id="loadingStep">
        <h2 class="confirmation-title">Processing your order...</h2>
        <p class="confirmation-msg">Please wait a moment.</p>
        <div class="progress-bar-wrap">
            <div class="progress-bar" id="progress"></div>
        </div>
    </div>

    <!-- Step 2: Final confirmation -->
    <div id="confirmationStep" class="hidden">
        <h2 class="confirmation-title">Order Confirmed 🎉</h2>
        <p class="confirmation-msg">Thank you! Your order has been placed successfully.</p>

        <div class="summary-line">
            <span>Shipping</span>
            <span>A$<?= number_format($order->shipping, 2) ?></span>
        </div>
        <div class="summary-line summary-total">
            <span>Total</span>
            <span>A$<?= number_format($order->total, 2) ?></span>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const progress = document.getElementById("progress");
        const loadingStep = document.getElementById("loadingStep");
        const confirmationStep = document.getElementById("confirmationStep");

        // Animate progress bar
        setTimeout(() => {
            progress.style.width = "100%";
        }, 200);

        // After animation ends, show confirmation
        setTimeout(() => {
            loadingStep.classList.add("hidden");
            confirmationStep.classList.remove("hidden");
        }, 1500); // matches transition duration
    });
</script>


