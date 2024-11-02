@csrf

<label for="name">Name</label>
<!-- old para manter a alteração, $product->name para pegar valor caso esteja na bd, ?? = ou branco para caso seja um novo produto. -->
<input type="text" name="name" id="name" value="{{ old('name', $product->name ?? '') }}">

<label for="descriptions">Description</label>
<textarea name="descriptions" id="descriptions">{{ old('descriptions', $product->descriptions ?? '') }}</textarea>

<label for="size">Size</label>
<input type="text" name="size" id="size" value="{{ old('size', $product->size ?? '') }}">

<button>Save</button>
