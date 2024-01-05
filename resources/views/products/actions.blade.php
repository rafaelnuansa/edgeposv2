<div class="dropdown d-inline-block">
    <button class="btn btn-soft-secondary btn-sm dropdown-toggle" type="button" id="dropdownActions" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="ri-more-fill align-middle"></i>
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownActions">
        <li>
            <a class="dropdown-item" href="{{ route('products.show', $product->id) }}">
                <i class="ri-eye-fill align-bottom me-2 text-muted"></i> View
            </a>
        </li>
        <li>
            <a class="dropdown-item edit-item-btn" href="{{ route('products.edit', $product->id) }}">
                <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
            </a>
        </li>
        <li>
            <a class="dropdown-item text-danger remove-item-btn" href="{{ route('products.destroy', $product->id) }}"
                onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
            </a>
        </li>
    </ul>
</div>
