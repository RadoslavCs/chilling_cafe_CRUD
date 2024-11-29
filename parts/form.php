<script>

function populateForm(item) {
    document.querySelector('input[name="update_id"]').value = item.id;
    document.querySelector('input[name="name"]').value = item.name;
    document.querySelector('select[name="drink_type"]').value = item.drink_type;
    document.querySelector('input[name="hot_price"]').value = item.hot_price;
    document.querySelector('input[name="iced_price"]').value = item.iced_price;
    document.querySelector('input[name="addon_price"]').value = item.addon_price;
    document.querySelector('input[name="blended_price"]').value = item.blended_price;
}
</script>