<x-app-layout>
    <div class="container inline-flex mx-auto mt-5">
        <form action="{{ route('event.store') }}" method="POST" id="form">
            @csrf

            <x-label value="Titre" />
            <x-input id="title" name="title" type="text" />


            <x-label for="content" value="Annonce" />
            <textarea name="content" id="content" cols="30" rows="10"></textarea>


            <x-label value="Premium ?" for="premium" />
            <x-input id="premium" name="premium" type="checkbox" />


            <x-label value="debut date" />
            <x-input id="starts_at" name="starts_at" type="date" />


            <x-label value="fin date" />
            <x-input id="ends_at" name="ends_at" type="date" />


            <x-label value="tags seperarés par une virgule ," />
            <x-input id="tags" name="tags" type="text" />


            <x-input id="payment_method" name="payment_method" type="hidden" />


            <div id="card-element"></div>

            <div class="block mt-3">
                <x-button type="submit" id="submit-button">creer mon event</x-button>
            </div>
        </form>
    </div>
    @section('extra-js')
        <script src="https://js.stripe.com/v3/"></script>

        <script>
            const stripe = Stripe('{{ env('STRIPE_KEY') }}');

            const elements = stripe.elements();
            const cardElement = elements.create('card', {
                classes: {
                    base: 'StripeElement bg-white  w-1/2 p-2 my-2 rounded-lg'
                }
            });



            cardElement.mount('#card-element');

            const cardButton = document.getElementById('submit-button');

            cardButton.addEventListener('click', async (e) => {
                e.preventDefault();

                const {
                    'paymentMethod, error'
                } = await stripe.createPaymentMethod('card', cardElement)

                if (error) {
                    alert(error);
                } else {
                    document.getElementById('payment_method').value = paymentMethod.id;
                }

                document.getElementById('form').submit()
            });
        </script>
    @endsection

</x-app-layout>
