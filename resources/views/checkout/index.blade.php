<div class="checkout-container">
    <h1>Checkout</h1>
    
    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        
        <div class="billing-details">
            <h2>Billing Details</h2>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="city">City</label>
                <input type="text" id="city" name="city" required>
            </div>
            <div class="form-group">
                <label for="zip">Zip Code</label>
                <input type="text" id="zip" name="zip" required>
            </div>
        </div>

        <div class="payment-details">
            <h2>Payment Details</h2>
            <div class="form-group">
                <label for="card_number">Card Number</label>
                <input type="text" id="card_number" name="card_number" required>
            </div>
            <div class="form-group">
                <label for="expiry_date">Expiry Date</label>
                <input type="text" id="expiry_date" name="expiry_date" required placeholder="MM/YY">
            </div>
            <div class="form-group">
                <label for="cvv">CVV</label>
                <input type="text" id="cvv" name="cvv" required>
            </div>
        </div>

        <button type="submit">Complete Checkout</button>
    </form>
</div>