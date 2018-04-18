const axios = require('axios');

let name = document.getElementById('name');
let team = document.getElementById('team');
let validationResult = document.getElementById('validation-result');
let validationResultTeam = document.getElementById('validation-resultTeam');
const validateName = function () {
    validationResult.innerText = '...';
    axios.post(validationResult.dataset.path, {input: name.value})
        .then(function(response) {
            if (response.data.valid) {
                validationResult.innerText = ":)";
            } else {
                validationResult.innerText = ":(";
            }
        })
        .catch(function (error) {
            validationResult.innerText = 'Error: ' + error;
        });
};
const validateTeam = function () {
    validationResultTeam.innerText = '...';
    axios.post(validationResultTeam.dataset.path, {input: team.value})
        .then(function(response) {
            if (response.data.valid) {
                validationResultTeam.innerText = ":)";
            } else {
                validationResultTeam.innerText = ":(";
            }
        })
        .catch(function (error) {
            validationResultTeam.innerText = 'Error: ' + error;
        });
};
name.onkeyup = validateName;
name.onchange = validateName;

team.onkeyup = validateTeam;
team.onchange = validateTeam;