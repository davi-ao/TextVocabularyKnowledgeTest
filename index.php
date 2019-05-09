<?php
$subproject = (!empty($_GET) ? $_GET["sub"] : "");

if ($subproject != 1 && $subproject != 2 && $subproject != 3) {
    $subproject = "";
}
?>
<!-- 0.8.4 -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Teste de Conhecimento de Vocabulário</title>

    <link href="./vendor/bootstrap-4.0.0/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="./vendor/jspsych-6.0.1/css/jspsych.css" rel="stylesheet" type="text/css">
    <link href="./vendor/fontawesome-5.0.1/web-fonts-with-css/css/fontawesome-all.min.css" rel="stylesheet" type="text/css">
    <link href="./resources/css/styles.css" rel="stylesheet" type="text/css">

    <script src="./vendor/jquery-3.3.1/jquery-3.3.1.min.js"></script>
    <script src="./vendor/jquery-3.3.1/jquery-fullscreen-plugin/jquery.fullscreen-min.js"></script>
    <script src="./vendor/popper/popper.min.js"></script>
    <script src="./vendor/bootstrap-4.0.0/dist/js/bootstrap.min.js"></script>
    <script src="./vendor/jspsych-6.0.1/jspsych.js"></script>
    <script src="./vendor/jspsych-6.0.1/plugins/jspsych-instructions.js"></script>
    <script src="./vendor/jspsych-6.0.1/plugins/jspsych-html-button-response.js"></script>
    <script src="./vendor/jspsych-6.0.1/plugins/jspsych-survey-text.js"></script>

    <style type="text/css">
        input {
            color: olivedrab;
        }
    </style>
</head>
<body>

</body>
<script>

$.getJSON("./resources/words/words<?php echo $subproject; ?>.json", function (data) {
    var words = Object.keys(data[0]);
    var trials = [{
        type: 'survey-text',
        questions: [
            {prompt: "<h2>Teste de Conhecimento de Vocabulário</h2>" +
            "<p>Antes de começar, por favor, digite seu nome completo:</p>",
            value: "", rows: 1, columns: 40}
        ],
        button_label: 'continuar',
        on_finish: function () {
            $(document).fullScreen(true);
        }
    },{
        type: 'instructions',
        pages: [
            '<h2>Teste de Conhecimento de Vocabulário</h2>' +
                '<p>Esse teste traz uma lista de palavras em língua inglesa que você deverá traduzir. ' +
                'Tal tradução pode ser uma palavra ou expressão correspondente, ou uma explicação do significado.' +
                'Caso você não conheça ou não tenha certeza sobre uma tradução possível de uma palavra, deixe o campo em branco. ' +
                'Caso alguma palavra tenha mais que uma tradução possível, digite as traduções que você considera mais relevantes, separando-as por vírgulas.</p>',
            '<h3>Sessão de treino</h3>' +
                '<p>Vamos iniciar com uma sessão de treino para familiarizar você com o teste.</p>',
        ],
        show_clickable_nav: true,
        button_label_previous: 'voltar',
        button_label_next: 'continuar'
    }];

    //Training session

    trials.push({
        type: 'survey-text',
        questions: [
            {prompt: "one", value: "", rows: 1, columns: 20},
            {prompt: "all", value: "", rows: 1, columns: 20},
            {prompt: "get", value: "", rows: 1, columns: 20},
            {prompt: "time", value: "", rows: 1, columns: 20},
            {prompt: "know", value: "", rows: 1, columns: 20},
            {prompt: "take", value: "", rows: 1, columns: 20},
            {prompt: "people", value: "", rows: 1, columns: 20},
            {prompt: "year", value: "", rows: 1, columns: 20},
            {prompt: "good", value: "", rows: 1, columns: 20},
            {prompt: "think", value: "", rows: 1, columns: 20},
        ],
        button_label: 'continuar'
    });

    trials.push({
        type: 'instructions',
        pages: ['<h3>Sessão de treino concluída</h3>' +
        '<p>Se tiver alguma dúvida, pergunte ao pesquisador.</p>' +
        '<p>Você pode optar por reiniciar o teste e fazer a sessão de treino novamente. <br> ' +
        'Para isso, basta teclar <kbd>F5</kbd> em seu teclado.</p>' +
        '<p>Se quiser começar o teste, basta clicar em continuar.</p>'],
        show_clickable_nav: true,
        button_label_previous: 'voltar',
        button_label_next: 'continuar'
    });

    //Trainning Session End

    var q = [];

    $.each(words, function(i, w) {
        q.push({prompt: w, value: "", rows: 1, columns: 20});
    });

    trials.push({
        type: 'survey-text',
        questions: q,
        button_label: 'continuar'
    });

    trials.push({
        type: 'instructions',
        pages: ['<h3>Teste finalizado</h3>' +
            '<p>Muito obrigado pela sua participação.</p>' +
            '<strong>Importante:</strong> clique em continuar para finalizar o instrumento.'],
        show_clickable_nav: true,
        button_label_previous: 'voltar',
        button_label_next: 'continuar'
    });

    jsPsych.init({
        timeline: trials,
        on_finish: function () {
            jQuery.post('./resources/php/save_data.php', {type: "tvkt", data: jsPsych.data.get().csv()}, function (response) {
                if (response.success == false) {
                    $("#jspsych-content").html(response);
                } else {
                    window.location = "./";
                }

                $(document).fullScreen(false);
            }).fail(function () {
                $("#jspsych-content").html('<a href="data:application/octet-stream,' + encodeURIComponent(jsPsych.data.get().csv()) + '" download="dados_' + Date.now() + '.csv">Baixar resultados</a>');
            });
        }
    });
});

</script>
</html>
