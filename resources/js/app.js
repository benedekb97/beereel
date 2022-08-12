require('jquery');
require('bootstrap');

import Modal from 'bootstrap';
import $ from 'jquery';
window.$ = window.jquery = $;

window.switchTo = function(e, id)
{
    let target = e.target;

    if ('src' in target) {
        let src = target.src;

        if (src.search('back') !== -1) {
            src = src.replace('back', 'front');
        } else {
            src = src.replace('front', 'back');
        }

        let image = document.getElementById(id);

        image.src = src;
    }
}

const REACTION_TYPES = [
    "LOVE",
    "LIKE",
    "SMILE",
    "WOW",
    "LOL",
    "ANGRY"
];

window.$('.reaction-button').click(
    function (event) {
        const reactionType = $(this).data('react');
        const postId = $(this).data('post-id');

        $.ajax(
            {
                method: "POST",
                url: $('#reaction-url').val(),
                data: {
                    _token: $('#csrf-token').val(),
                    post: postId,
                    reactionType: reactionType
                },
                dataType: "JSON",
                success: function (e) {
                    REACTION_TYPES.forEach(
                        function (element) {
                            $(`#react-${postId}-${element}`).removeClass('bg-secondary');
                            $(`#react-${postId}-${element}`).addClass('bg-dark');
                        }
                    );

                    if ('reactionType' in e) {
                        $(`#react-${postId}-${e.reactionType}`).addClass('bg-secondary');
                        $(`#react-${postId}-${e.reactionType}`).removeClass('bg-dark');
                    }


                    let modal = new bootstrap.Modal(document.getElementById(`#reaction-modal-${postId}`));

                    modal.hide();
                },
                failure: function (e) {
                    console.log(e);
                }
            }
        )
    }
)
