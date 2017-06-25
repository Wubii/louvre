
$(window).scroll(function()
{
  var scroll = $(document).scrollTop();

  if (window.matchMedia("(min-width: 980px)").matches) {
    if(scroll > 294)
    {
      $('#fixed-basket').css({
        'position': 'fixed',
        'right': '95px',
        'top': '320px'
      });
    }
    else 
    {
      $('#fixed-basket').css({
        'position': 'absolute',
        'right': '95px',
        'top': '614px'
      });
    }
    //console.log($('#fixed-basket').offset().top);
    console.log();
  }
})

function hideBasket()
{
  $('#fixed-basket').addClass('hidden');
  $('#fixed-basket-down').addClass('hidden');
  $('#fixed-basket-down-row').addClass('hidden');
}

function hiddenClass(){

  if (window.matchMedia("(min-width: 1200px)").matches) 
    {
      $('#fixed-basket').removeClass('hidden');
      $('#fixed-basket-down').addClass('hidden');
      $('#fixed-basket-down-row').addClass('hidden');
    }
    else
    {
      $('#fixed-basket-down').removeClass('hidden');
      $('#fixed-basket-down-row').removeClass('hidden');
      $('#fixed-basket').addClass('hidden');
    }
}

$(window).resize(function() 
{
  if(!$( "#fixed-basket" ).hasClass( "hidden" ) 
    || 
    !$( "#fixed-basket-down" ).hasClass( "hidden" ) 
    || 
    !$( "#fixed-basket-down" ).hasClass( "hidden" ))
  {
    hiddenClass();
  }

});

function updateBasket()
{
  $('#payment-row').removeClass('hidden');

  hiddenClass();
  
  var users = [];

  var htmlUsers = $('#appbundle_mborder_users > .form-group');
  
  htmlUsers.each(function()
  {
    var firstname = $(this).find('.form-group input[id$=firstname]').val();
    var lastname = $(this).find('.form-group input[id$=lastname]').val();
    var birthdayYear = $(this).find('.form-group select[id$=birthday_year]').val();
    var birthdayMonth = $(this).find('.form-group select[id$=birthday_month]').val();
    var birthdayDay = $(this).find('.form-group select[id$=birthday_day]').val();
    var isReduced = $(this).find('.form-group input[id$=isReduced]:checked').val();
    birthday = birthdayYear + "-" + birthdayMonth + "-" + birthdayDay;

    user = [firstname, lastname, birthday, isReduced];
    users.push(user);
  })

  console.log(JSON.stringify(users));
  // $.post( "{{ path('getUsersPrice')}}", {users: JSON.stringify(users)})
  $.post( "/getUsersPrice", {users: JSON.stringify(users)})
    .done(function( usersJSON )
    {
      var basket = $('.basket-content');
      basket.empty();

      var users = JSON.parse(usersJSON);
      var totalPrice = 0;

      users.forEach(function(user)
      {
        var firstname = user[0];
        var lastname = user[1];
        var price = user[4];
        totalPrice += parseInt(price);

        var tr = document.createElement("tr");  

        var tdName = document.createElement("td");
        var textnode = document.createTextNode(firstname + " " + lastname);  
        tdName.appendChild(textnode);
        
        var tdPrice = document.createElement("td");
        tdPrice.setAttribute("style", "text-align:right"); 
        var textnode = document.createTextNode(price);
        tdPrice.appendChild(textnode);

        tr.appendChild(tdName);
        tr.appendChild(tdPrice);

        basket.append(tr);
      })

      var trTotal = document.createElement("tr");
      trTotal.setAttribute("style", "border-top:1px solid white")

      var tdName = document.createElement("td");
      var textnode = document.createTextNode("TOTAL");  
      tdName.appendChild(textnode);

      var tdPrice = document.createElement("td");
      tdPrice.setAttribute("style", "text-align:right"); 
      var textnode = document.createTextNode(totalPrice);
      tdPrice.appendChild(textnode);

      trTotal.appendChild(tdName);
      trTotal.appendChild(tdPrice);

      basket.append(trTotal);
    });
}

$('#validate').click(function(e)
{
  var validate = true;

  if ($('#appbundle_mborder_email')[0].checkValidity() == false)
  {
    validate = false;
  }

  $('.not-empty').each(function(index)
  {
    if($(this)[0].checkValidity() == false) 
    {
      validate = false;
    };
  })

  $('.is-not-empty > select').each(function(index)
  {
    if ($(this).val() == "")
    {
      validate = false;
    }  
  })

  if(validate == true)
  {
    updateBasket();
  }
  else 
  {
    hideBasket();    
    alert("Vous n'avez pas rempli les champs correctement");
  }
})

$('#order-edit').click(function(e)
{
  $('#order-form').attr('disabled', null);
  $('#payment-row').addClass('hidden');
  $('#fixed-basket').addClass('hidden');
  $('#fixed-basket-down').addClass('hidden');
  $('#fixed-basket-down-row').addClass('hidden');
  
})