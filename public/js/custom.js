$(document).ready(function () {

    //send ajax to remove participant in current company
    function removeParticipant () {
    $('.participant-list').on('click', '#remove-participant', function () {
        let user_id = $(this).data('user-id');
        let data = 'user_id=' + user_id;
        axios
            .post('remove/participant/' + user_id, data)
            .then(function (response) {
                if(response.data.remove_user == 1){
                    $(this).closest('.item-row-' + user_id).remove();
                }else{
                    console.log(response);
                }
            }.bind(this))
            .catch(error => console.log(error));
    })}
    removeParticipant()

    // start mailing for current company ID
    $('#start-mailing').on('click', function (e) {
        let compani_id = $('#id-company').val();
        let data = 'company_id=' + compani_id;
        axios
            .post('start-mailing', data)
            .then(function (response) {
                $('#sendSuccessful').html(
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">\n' +
                    '    Sending was successful\n' +
                    '    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                    '        <span aria-hidden="true">&times;</span>\n' +
                    '    </button>\n' +
                    '</div>'
                )
            }.bind(this))
            .catch(error => console.log(error));

        e.preventDefault();
    })

    // update participants list for current company ID
    $('#id-company').change(function () {
        let compani_id = $('select[name=id-company] option').filter(':selected').val();
        let data = 'company_id=' + compani_id;
        axios
            .post('update/participant', data)
            .then(function (response) {
                if(response.data.update === true) {
                    $('.block-participant-list #participant-list').remove();
                    $('.block-participant-list').prepend(response.data.participant_list);
                    removeParticipant()
                    initPeerReflection()
                    initSelfReflection()
                }

            }.bind(this))
            .catch(error => console.log(error));
        //e.preventDefault();
    })

    // select ajax to check peer_reflection
    $('#selectAllPeerReflections').on('click', function (e) {
        let users_id = (() => {
            let list = ''
            document.querySelectorAll(".participant-list input[name='peer_reflection']").forEach( e => {if(!e.checked) {
                list += (e.dataset.userId + ',')
                e.checked  = true
            }})
            return list.slice(0, -1)
        })()
        if (!!users_id) {
            let data = 'peer_reflection=' + users_id;
            axios
                .post('update/peer-reflection', data)
                .then(function (response) {
                }.bind(this))
                .catch(error => console.log(error));
        }

    })

    function initPeerReflection () {
        $(".participant-list input[name='peer_reflection']").on('click', function (e) {
            let user_id = e.target.dataset.userId;
            let data = 'peer_reflection=' + user_id;
            if (e.target.checked) {
                axios
                    .post('update/peer-reflection', data)
                    .then(function (response) {
                    }.bind(this))
                    .catch(error => console.log(error));
            } else {
                axios
                    .post('remove/peer-reflection', data)
                    .then(function (response) {
                    }.bind(this))
                    .catch(error => console.log(error));
            }
        })
    }
    initPeerReflection()

    // select ajax to check self_reflection
    $('#selectAllSelfReflections').on('click', function (e) {
        let users_id = (() => {
            let list = ''
            document.querySelectorAll(".participant-list input[name='self_reflection']").forEach( e => {if(!e.checked) {
                list += (e.dataset.userId + ',')
                e.checked  = true
            }})
            return list.slice(0, -1)
        })()

        if (!!users_id) {
            let data = 'self_reflection=' + users_id;
            axios
                .post('update/self-reflection', data)
                .then(function (response) {
                }.bind(this))
                .catch(error => console.log(error));
        }
    })

    function initSelfReflection () {
        $(".participant-list input[name='self_reflection']").on('click', function (e) {
            let user_id = e.target.dataset.userId;
            let data = 'self_reflection=' + user_id;
            if (e.target.checked) {
                axios
                    .post('update/self-reflection', data)
                    .then(function (response) {
                    }.bind(this))
                    .catch(error => console.log(error));
            } else {
                axios
                    .post('remove/self-reflection', data)
                    .then(function (response) {
                    }.bind(this))
                    .catch(error => console.log(error));
            }
        })
    }
    initSelfReflection()


    // send ajax to remove current company
    $('#remove-company').on('click', function (e) {
        let current_company_id = $('select[name=id-company] option').filter(':selected').val();
        let data = 'company_id=' + current_company_id;
        axios
            .post('remove/company', data)
            .then(function (response) {
                if(response.data.remove === true) {
                    $("select[name=id-company]").val(response.data.company_id);
                    $("option[value=" + current_company_id + "]").remove();
                    $('#id-company').change();
                    //let current_option $("select[name=id-company] option[value='2']").attr('selected', 'true')
                }
            }.bind(this))
            .catch(error => console.log(error));
        e.preventDefault();
    })

    // send ajax for save csv file and parse file data
    $('#save-file').on('click', function (e) {
        if($('#csv-file').val()){
            let file_data = $('#csv-file').prop('files')[0];
            let form_data = new FormData();
            let token = $('meta[name="csrf-token"]').attr('content');
            let id_form_self_reflection = $('#id-form-self-reflection').val();
            let id_form_peer_collection = $('#id-form-peer-collection').val();
            let id_form_peer_reflection = $('#id-form-peer-reflection').val();
            form_data.append('csv_file', file_data);
            form_data.append('_token', token);
            form_data.append('id_form_self_reflection', id_form_self_reflection);
            form_data.append('id_form_peer_collection', id_form_peer_collection);
            form_data.append('id_form_peer_reflection', id_form_peer_reflection);
            $.ajax({
                url: 'save-csv-file',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(response){
                    if(response.save_file === true){
                        $('#fileSuccessful').html(
                            '<div class="alert alert-success alert-dismissible fade show" role="alert">\n' +
                            '    File saved successfully!\n' +
                            '</div>'
                        )
                        setTimeout( function() {window.location.replace('/')}, 3000)
                    }
                }
            });
        }
        e.preventDefault();
    });

    $('#csv-file').on('change', (e) => $('#csv-file + .custom-file-label').text(e.target.value))

    //$('#addParticipantModalButton').on('click', () => $('#addParticipantSubmitButton').click())

    //send ajax for create new paticipant
    $('#addParticipantModalButton').on('click', function (e) {

        let data = $('#participant-add').serialize();
        axios
            .post('create/participant', data)
            .then(function (response) {
                if(response.data.create_user === true){
                    $('#addParticipant .close').click();
                    $('#sendSuccessful').html(
                        '<div class="alert alert-success alert-dismissible fade show" role="alert">\n' +
                        '    Success add new paticipant\n' +
                        '    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                        '        <span aria-hidden="true">&times;</span>\n' +
                        '    </button>\n' +
                        '</div>'
                    )
                    setTimeout( function() {window.location.replace('/')}, 3000)
                }
            }.bind(this))
            .catch(function (error) {
                $('#form-errors').html(
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">\n' +
                    '    Please fill out the form!\n' +
                    '    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                    '        <span aria-hidden="true">&times;</span>\n' +
                    '    </button>\n' +
                    '</div>'
                )
            });
        e.preventDefault();
    })


    // update survey forms id on page
    var timeoutSurveyIdUpdate = null;
    function updateSurveyFormId(){

        $('.survey-id').bind('keyup change', function () {

            let form_id = $(this).val();
            let form_name = $(this).attr('name');
            if(form_id.length){
                updateFormId(form_id, form_name);
            }

        });
    }
    updateSurveyFormId();

    function updateFormId(form_id, form_name) {

        if (timeoutSurveyIdUpdate) {
            window.clearTimeout(timeoutSurveyIdUpdate);
        }
        timeoutSurveyIdUpdate = setTimeout(function() {

            let form_data = new FormData();
            let company_id = $('select[name=id-company] option').filter(':selected').val();
            let token = $('meta[name="csrf-token"]').attr('content');
            form_data.append('_token', token);
            form_data.append('form_id', form_id);
            form_data.append('form_name', form_name);
            form_data.append('company_id', company_id);
            $.ajax({
                url: 'update/survey-id',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(response){
                    if(response.update === true){
                        $('#sendSuccessful').html(
                            '<div class="alert alert-success alert-dismissible fade show" role="alert">\n' +
                            '    Success update survey form ID\n' +
                            '    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                            '        <span aria-hidden="true">&times;</span>\n' +
                            '    </button>\n' +
                            '</div>'
                        )
                    }
                    console.log(response);
                }
            });

        }, 1000, form_id, form_name);
    }

    //update survey form id after changed company
    $('#id-company').change(function () {
        let compani_id = $('select[name=id-company] option').filter(':selected').val();
        let data = 'company_id=' + compani_id;
        axios
            .post('change/survey-id', data)
            .then(function (response) {
                console.log(response)
                if(response.data.change === true) {
                    $('#survey-forms-id').empty();
                    $('#survey-forms-id').append(response.data.forms_id);
                    removeParticipant()
                    initPeerReflection()
                    initSelfReflection()
                    updateSurveyFormId()
                }

            }.bind(this))
            .catch(error => console.log(error));
        //e.preventDefault();
    })
});
