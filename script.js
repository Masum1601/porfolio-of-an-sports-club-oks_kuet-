document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    e.preventDefault();
    const target = document.querySelector(this.getAttribute('href'));
    if (target) {
      target.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
      });
    }
  });
});

window.addEventListener('scroll', () => {
  const navLinks = document.querySelectorAll('.navbar a');
  
  navLinks.forEach(link => {
    link.classList.remove('active');
  });
});

document.querySelectorAll('.btn').forEach(button => {
  button.addEventListener('click', function() {
    console.log('Button clicked');
  });
});

document.addEventListener('DOMContentLoaded', function() {
  console.log('Page loaded successfully');
});
