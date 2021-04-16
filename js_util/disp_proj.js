let id = $('input[name*="prod_id"]');
id.attr ('readonly', 'readonly');

$('.btnedit').click (e => {
    let textvalues = displayData (e);

    let type = $('input[name*="type"]');
    let deadline = $('input[name*="deadline"]');
    let team = $('input[name*="team_id"]');
    let state = $('input[name*="finished"]');

    id.val (textvalues[0]);
    type.val (textvalues[1]);
    deadline.val (textvalues[2]);
    team.val (textvalues[3]);
    state.val (textvalues[4]);
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