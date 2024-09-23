<!-- pagination.blade.php -->
<div class="pagination">
    {{ $items->links() }} <!-- Assuming $items is your paginated data -->
</div>

<style>
    .pagination {
    display: flex;
    justify-content: center; /* Align pagination in the center */
    padding: 10px 0;
}

.pagination .page-item {
    margin: 0 5px;
}

.pagination .page-item a,
.pagination .page-item span {
    display: inline-block;
    padding: 10px 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #f9f9f9;
    color: #007bff;
    text-decoration: none;
}

.pagination .page-item.active span {
    background-color: #007bff;
    color: #fff;
    border-color: #007bff;
}

.pagination .page-item.disabled span {
    color: #999;
}

.pagination .page-item .page-link {
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.pagination .page-item .page-link svg {
    width: 24px;
    height: 24px;
}

</style>