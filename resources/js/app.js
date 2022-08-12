require('jquery');
require('bootstrap');

import $ from 'jquery';
import Modal from 'bootstrap/js/src/modal';
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
        const userId = $('#user-id').val();

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

                    let reactionButton = $(`#reaction-button-${postId}`);
                    let reactionCount = $(`#reaction-count-${postId}`);

                    if ('reactionCount' in e) {
                        let newReactionCount = e.reactionCount;

                        reactionButton.css('display','inline');
                        reactionCount.html(newReactionCount);

                        if ('username' in e && 'reactionHTML' in e && 'id' in e) {
                            if ($(`#reaction-${e.id}`).length) {
                                $(`#reaction-${e.id}`).html(e.reactionHTML);
                            } else {
                                let reactionContainer = $(`#reaction-container-${postId}`);

                                let originalContent = reactionContainer.html();

                                originalContent += (`<div class="row" id="reaction-list-post-${postId}-user-${userId}"><div class="col">${e.username}</div><div class="col" style="text-align:right;" id="reaction-${e.id}">${e.reactionHTML}</div></div>`);

                                reactionContainer.html(originalContent);
                            }
                        }
                    } else {
                        let newReactionCount = reactionCount.html() - 1;

                        if (newReactionCount === 0) {
                            reactionButton.css('display','none');
                        } else {
                            reactionCount.html(newReactionCount);
                        }

                        $(`#reaction-list-post-${postId}-user-${userId}`).remove();
                    }

                    $(`#close-modal-${postId}`).click();
                },
                failure: function (e) {
                    console.log(e);
                }
            }
        )
    }
)
