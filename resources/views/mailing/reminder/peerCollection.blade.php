<div>
    <div>Hello, {{ $first_name }}</div>
    <br>
    <div>We are waiting for you to provide emails of coworkers, friends and family members!</div>
    <br>
    <div><a href="https://movemountains.typeform.com/to/{{ $form_id }}?participant_id={{ $user_id }}&participant_fname={{ $first_name }}&participant_lname={{ $last_name }}">https://movemountains.typeform.com/to/{{ $form_id }}?participant_id={{ $user_id }}&participant_fname={{ $first_name }}&participant_lname={{ $last_name }}</a></div>
    <br>
    <div>Thank you,</div>
    <br>
    <div>The Move Mountains Team</div>
</div>
<br>
<div>
    <a href="http://161.35.3.39/unsubscribe/peer-collection/{{ $user_id }}">Unsubscribe from a reminder</a>
</div>
