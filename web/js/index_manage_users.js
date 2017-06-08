$( "#appbundle_mborder_users + div.form-group + label:first-child" ).text('Participant n°1');

  var index = 0;

  function initIndex()
  {
    var $container = $('div#appbundle_mborder_users');
    index = $container.find('.index').length;
  }
  
  $(document).ready(function()
  {    
    var $container = $('div#appbundle_mborder_users');
    initIndex();

    $('#add_user').click(function(e)
    {
      addUser($container);
      e.preventDefault();
      return false;
    });

    if(index == 0)
    {
      addUser($container)
    }

    function addUser($container)
    {
      var template = $container.attr('data-prototype')
        .replace(/__name__label__/g, 'Participant n°' + (index + 1))
        .replace(/__name__/g, index)

      ;

      var $prototype = $(template);

      addDeleteLink($prototype);

      $container.append($prototype);
        //$( "label.control-label" ).remove();

      index++;
    }

    function addDeleteLink($prototype)
    {
      var $deleteLink = $('<a href="#" class="remove-user btn btn-danger pull-right" style="margin-right:20px; margin-top:10px;">Supprimer ce visiteur</a>');

      $prototype.append($deleteLink);

      $deleteLink.click(function(e)
      {
        $prototype.remove();

        initIndex();
        var $users = $('#appbundle_mborder_users > div > label');
        var i = 1;

        $users.each(function()
        {
          $(this).text('Participant n°' + i++);
        })

        e.preventDefault();
        return false;
      });
    }

  })