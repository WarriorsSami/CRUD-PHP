let id = $('input[name*="ang_id"]');
id.attr ('readonly', 'readonly');

$('.btnedit').click (e => {
    let textvalues = displayData (e);

    let prenume = $('input[name*="ang_name"]');
    let nume = $('input[name*="ang_surname"]');
    let adresa = $('input[name*="ang_adr"]');
    let email = $('input[name*="ang_email"]');
    let manager = $('input[name*="is_manager"]');
    let tleader = $('input[name*="is_lead"]');
    let jdate = $('input[name*="date"]');
    let salary = $('input[name*="money"]');
    let dep = $('input[name*="dep_id"]');
    let team = $('input[name*="team_id"]');

    id.val (textvalues[0]);
    prenume.val (textvalues[1]);
    nume.val (textvalues[2]);
    email.val (textvalues[3]);
    adresa.val (textvalues[4]);
    manager.val (textvalues[5]);
    tleader.val (textvalues[6]);
    jdate.val (textvalues[7]);
    salary.val (textvalues[8].replace ('$', ''));
    dep.val (textvalues[9]);
    team.val (textvalues[10]);
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