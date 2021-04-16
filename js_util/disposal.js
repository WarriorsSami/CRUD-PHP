let id = $('input[name*="client_id"]');
id.attr ('readonly', 'readonly');

$('.btnedit').click (e => {
    let textvalues = displayData (e);

    let prenume = $('input[name*="client_name"]');
    let nume = $('input[name*="client_surname"]');
    let email = $('input[name*="client_email"]');
    let adresa = $('input[name*="client_adr"]');

    id.val (textvalues[0]);
    prenume.val (textvalues[1]);
    nume.val (textvalues[2]);
    email.val (textvalues[3]);
    adresa.val (textvalues[4]);
});

function displayData (e) {
    let id = 0;
    const td = $('#tbody tr td');
    let textvalues = [];

    for (const value of td) {
        if (value.dataset.id == e.target.dataset.id) {
            textvalues[id ++] = value.textContent;
        }
    }

    return textvalues;
}