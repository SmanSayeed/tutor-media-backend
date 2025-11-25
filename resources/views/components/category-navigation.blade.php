Category navigation component extracted from the welcome page.

<section class="container mx-auto px-4 py-4">
  <div class="flex overflow-x-auto space-x-4 md:grid md:grid-cols-4 md:gap-4">
    <a href="/category/men-sneakers" class="flex-shrink-0 p-2 bg-gray-200 rounded">Men's Sneakers</a>
    <a href="/category/men-formal" class="flex-shrink-0 p-2 bg-gray-200 rounded">Men's Formal</a>
    <a href="/category/men-casual" class="flex-shrink-0 p-2 bg-gray-200 rounded">Men's Casual</a>
    <a href="/category/men-boots" class="flex-shrink-0 p-2 bg-gray-200 rounded">Men's Boots</a>
  </div>
  <form action="/category" method="POST" class="mt-4 flex space-x-2">
    <select name="category_id" class="p-2 border rounded focus:outline-none">
      <option value="">All Categories</option>
      <option value="1">Men's Sneakers</option>
      <option value="2">Men's Formal</option>
    </select>
    <select name="size" class="p-2 border rounded focus:outline-none">
      <option value="">All Sizes</option>
      <option value="S">Small</option>
      <option value="M">Medium</option>
    </select>
    <button type="submit" class="p-2 bg-blue-500 text-white rounded">Filter</button>
  </form>
</section>