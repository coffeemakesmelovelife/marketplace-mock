
  $(document).on('click', '.like', function(){
    var id = $(this).attr('data-id');
    var self = this;
    $.ajax({
      type: 'POST',
      url: '{{ path(('upvotepost')) }}',
      data: {
        id: id
      },
      success: function(data, textStatus, xhrStatus){
        if(xhrStatus.status == 200){
          var newCount = parseInt($('#upvote-'+id).text());
          newCount++;
          $('#upvote-'+id).html(newCount);
          $(self).removeClass('like').addClass('unlike');
        }
      }
    });
  });

  $(document).on('click', '.unlike', function(){
    var id = $(this).attr('data-id');
    var user_id = $(this).attr('data-userid');
    var post_id = $(this).attr('data-postid');
    var self = this;
    $.ajax({
      type: 'POST',
      url: '{{ path(('downvotepost')) }}',
      data: {
        user_id: user_id,
        post_id: post_id

      },
      success: function(data, textStatus, xhrStatus){
        if (xhrStatus.status == 200) {
          var newCount = parseInt($('#upvote-'+id).text());
          newCount--;
          $('#upvote-'+id).html(newCount);
          $(self).removeClass('unlike').addClass('like');
        }
      }
    });
  });

  $('.container').infiniteScroll({
    path: '/page/{{ '{{#}}' }}',
    append: '.post',
    button: '.view-more-button',
    scrollThreshold: false,
    status: '.page-load-status',
  });
