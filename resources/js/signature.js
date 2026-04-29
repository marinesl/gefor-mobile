import SignaturePad from 'signature_pad';

var signaturePad = new SignaturePad(document.getElementById('signature-pad'), {
  backgroundColor: 'rgba(255, 255, 255, 0)',
  penColor: 'rgb(0, 0, 0)'
});
var saveButton = document.getElementById('save');
var cancelButton = document.getElementById('clear');

// For form submission
const signatureInput = document.getElementById('signature_input');
const form = document.getElementById('signature-form');

saveButton.addEventListener('submit', function (event) {
    if (signaturePad.isEmpty()) {
        event.preventDefault(); // stop submission
        alert('Veuillez signer avant d\'enregistrer.');
        return;
    }

    // Convert canvas to base64 and put it in the hidden input
    signatureInput.value = signaturePad.toDataURL('image/png');

    // Submit the form normally (Laravel handles it)
    //form.submit();
});

cancelButton.addEventListener('click', function (event) {
    event.preventDefault(); // stop submission
  signaturePad.clear();
});
