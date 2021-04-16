let id = $('input[name*="order_id"]');
id.attr ('readonly', 'readonly');

$('.btnedit').click (e => {
    let textvalues = displayData (e);

    let date = $('input[name*="deadline"]');
    let client = $('input[name*="client_id"]');
    let prod = $('input[name*="prod_id"]');
    let team = $('input[name*="team_id"]');

    id.val (textvalues[0]);
    date.val (textvalues[1]);
    client.val (textvalues[2]);
    prod.val (textvalues[3]);
    team.val (textvalues[4]);
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