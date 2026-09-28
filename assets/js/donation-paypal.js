/**
 * Donation form — PayPal Smart Buttons.
 *
 * The amount comes from #donationAmount, which script.js fills from the
 * preset buttons or unlocks for typing when "Custom" is picked.
 */
(function () {
  'use strict';

  var container = document.getElementById('paypal-button-container');
  if (!container || typeof paypal === 'undefined') {
    return;
  }

  var form = document.getElementById('donationForm');
  var input = document.getElementById('donationAmount');
  var message = form.querySelector('.donation-message');

  function field(name) {
    var el = form.querySelector('[name="' + name + '"]');
    return el ? el.value.trim() : '';
  }

  // "£50", "50.5", "1,000" → "50.00", "50.50", "1000.00"; null when unusable.
  function readAmount() {
    var value = parseFloat(input.value.replace(/[^0-9.]/g, ''));
    return value >= 1 ? value.toFixed(2) : null;
  }

  function showMessage(text, isError) {
    message.textContent = text;
    message.style.color = isError ? '#d63638' : '';
    message.hidden = !text;
  }

  paypal
    .Buttons({
      style: { layout: 'vertical', shape: 'rect', label: 'donate' },

      onClick: function (data, actions) {
        if (!readAmount()) {
          showMessage('Please enter a donation amount of at least 1.', true);
          input.focus();
          return actions.reject();
        }
        showMessage('');
        return actions.resolve();
      },

      createOrder: function (data, actions) {
        var cause = field('cause');

        return actions.order.create({
          purchase_units: [
            {
              amount: {
                value: readAmount(),
                currency_code: form.dataset.currency || 'GBP',
              },
              description: cause ? 'Donation: ' + cause : 'Donation',
              custom_id: field('cause_id') || undefined,
            },
          ],
        });
      },

      onApprove: function (data, actions) {
        return actions.order.capture().then(function (details) {
          var name = field('name') || details.payer.name.given_name;
          form.innerHTML =
            '<p class="donation-thanks">Thank you for your donation, ' +
            name.replace(/[<>&"]/g, '') +
            '! A receipt has been sent to your PayPal email.</p>';
        });
      },

      onError: function () {
        showMessage('Something went wrong with PayPal. Please try again.', true);
      },
    })
    .render('#paypal-button-container');
})();
