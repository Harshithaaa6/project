<script>
function getError() {
    let errorName = document.getElementById("errorInput").value;

    fetch("api.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ error: errorName })
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById("result").innerText = data.result;
    })
    .catch(err => console.log(err));
}
</script>
