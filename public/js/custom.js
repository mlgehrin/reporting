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
        let compani_id = $('select[name=company_id] option').filter(':selected').val();
        let data = 'company_id=' + compani_id;
        axios
            .post('start-mailing', data)
            .then(function (response) {
                console.log(response);
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
                console.log('update participant',response);
            }.bind(this))
            .catch(error => console.log(error));
        //e.preventDefault();
        console.log('update participant', compani_id);

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
                    console.log('set peer_reflection',response);
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
                        console.log('set peer_reflection',response);
                    }.bind(this))
                    .catch(error => console.log(error));
            } else {
                axios
                    .post('remove/peer-reflection', data)
                    .then(function (response) {
                        console.log('remove peer_reflection',response);
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
                    console.log('set self_reflection', response);
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
                        console.log('set self_reflection',response);
                    }.bind(this))
                    .catch(error => console.log(error));
            } else {
                axios
                    .post('remove/self-reflection', data)
                    .then(function (response) {
                        console.log('remove self_reflection',response);
                    }.bind(this))
                    .catch(error => console.log(error));
            }
        })
    }
    initSelfReflection()


    // send ajax to remove current company
    $('#remove-company').on('click', function (e) {
        let compani_id = $('select[name=id-company] option').filter(':selected').val();
        let data = 'company_id=' + compani_id;
        axios
            .post('remove/company', data)
            .then(function (response) {
                if(response.data.remove === true) {
                    $("select[name=id-company]").val(response.data.company_id);
                    $('#id-company').change();
                    //let current_option $("select[name=id-company] option[value='2']").attr('selected', 'true')
                }
                console.log('remove', response);
            }.bind(this))
            .catch(error => console.log(error));
        e.preventDefault();
        console.log('remove', compani_id);
    })

    // send ajax for save csv file and parse file data
    $('#save-file').on('click', function (e) {
        if($('#csv-file').val()){
            let file_data = $('#csv-file').prop('files')[0];
            let form_data = new FormData();
            let token = $('meta[name="csrf-token"]').attr('content');
            form_data.append('csv_file', file_data);
            form_data.append('_token', token);

            $.ajax({
                url: 'save-csv-file',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(response){
                    if(response.save_file === true){
                        alert('File saved successfully!');
                        window.location.replace('/');
                    }
                }
            });
        }
        e.preventDefault();
    });

    $('#csv-file').on('change', (e) => $('#csv-file + .custom-file-label').text(e.target.value))

    $('#addParticipantModalButton').on('click', () => $('#addParticipantSubmitButton').click())
});
