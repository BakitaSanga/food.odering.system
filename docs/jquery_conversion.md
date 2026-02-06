# jQuery to Vanilla JS Conversion - Quick Reference

## Completed Conversions
- [x] login.html - Converted to vanilla JS + Fetch API
- [x] signup.html - Converted to vanilla JS + Fetch API  
- [x] forgot_password.html - Converted to vanilla JS + Fetch API

## Remaining Conversions
- [ ] reset_password.html - Password toggle + form submission
- [ ] cart.html - Cart operations (update qty, delete, checkout)
- [ ] checkout.html - Order placement

## Common Patterns Used

### jQuery → Vanilla JS
```javascript
// Selectors
$('#id') → document.getElementById('id')
$('.class') → document.querySelector('.class')
$('tag') → document.querySelector('tag')

// Events
$('#id').click(fn) → document.getElementById('id').addEventListener('click', fn)
$('#form').submit(fn) → document.getElementById('form').addEventListener('submit', fn)

// Attributes
$(el).attr('type', 'text') → el.type = 'text'
$(el).prop('disabled', true) → el.disabled = true

// Content
$(el).text('text') → el.textContent = 'text'
$(el).html('html') → el.innerHTML = 'html'

// Classes
$(el).toggleClass('class') → el.classList.toggle('class')

// AJAX → Fetch
$.ajax({
  url: 'url',
  method: 'POST',
  data: $(form).serialize()
}) 
→ 
fetch('url', {
  method: 'POST',
  body: new FormData(form)
})
```

## Testing Checklist
- [ ] Login functionality
- [ ] Signup functionality
- [ ] Forgot password
- [ ] Reset password
- [ ] Cart operations
- [ ] Checkout process
