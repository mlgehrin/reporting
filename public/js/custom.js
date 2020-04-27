$(document).ready(function () {
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

        //console.log(user_id);
    })

    $('#csv-file').on('change', (e) => $('#csv-file + .custom-file-label').text(e.target.value))

    $('#addParticipantModalButton').on('click', () => $('#addParticipantSubmitButton').click())
});
