function copyToClipboardFixed(text, button) {
  // طريقة مباشرة ومضمونة
  if (navigator.clipboard) {
    navigator.clipboard.writeText(text).then(function() {
      showSuccess(button);
    }).catch(function() {
      oldCopyMethod(text, button);
    });
  } else {
    oldCopyMethod(text, button);
  }
}

function oldCopyMethod(text, button) {
  const textarea = document.createElement('textarea');
  textarea.value = text;
  textarea.setAttribute('readonly', '');
  textarea.style.position = 'absolute';
  textarea.style.left = '-9999px';
  document.body.appendChild(textarea);
  textarea.select();
  document.execCommand('copy');
  document.body.removeChild(textarea);
  showSuccess(button);
}

function showSuccess(button) {
  const span = button.querySelector('.copy-text');
  button.classList.add('copied');
  span.textContent = 'تم النسخ!';
  setTimeout(() => {
    button.classList.remove('copied');
    span.textContent = 'نسخ';
  }, 2000);
}