let id = $('input[name*="id"]');
id.attr ('readonly', 'readonly');

$('.btnedit').click (e => {
    let textvalues = displayData (e);

    let descriere = $('input[name*="prod_name"]');
    let cerinte = $('textarea[name*="prod_task"]');
    let disponibil = $('input[name*="prod_disp"]');

    id.val (textvalues[0]);
    descriere.val (textvalues[1]);
    cerinte.val (textvalues[2]);
    disponibil.val (textvalues[3]);
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