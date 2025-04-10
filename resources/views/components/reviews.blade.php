@props(['product'])

<div class="mt-8">
    <h2 class="text-2xl font-bold mb-4">Reviews</h2>
    
    <!-- Review Form -->
    @auth
        <form action="{{ route('reviews.store', $product) }}" method="POST" class="mb-8">
            @csrf
            <div class="mb-4">
                <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
                <select name="rating" id="rating" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="5">5 Stars</option>
                    <option value="4">4 Stars</option>
                    <option value="3">3 Stars</option>
                    <option value="2">2 Stars</option>
                    <option value="1">1 Star</option>
                </select>
                @error('rating')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="comment" class="block text-sm font-medium text-gray-700">Comment</label>
                <textarea name="comment" id="comment" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                @error('comment')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                Submit Review
            </button>
        </form>
    @endauth
    
    <!-- Reviews List -->
    <div class="space-y-4">
        @foreach($product->reviews()->with('user')->latest()->get() as $review)
            <div class="border rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="text-yellow-400">
                            @for($i = 0; $i < $review->rating; $i++)
                                ★
                            @endfor
                        </div>
                        <span class="ml-2 font-medium">{{ $review->user->name }}</span>
                    </div>
                    <span class="text-gray-500 text-sm">{{ $review->created_at->diffForHumans() }}</span>
                </div>
                <p class="mt-2 text-gray-600">{{ $review->comment }}</p>
                
                @if(auth()->id() === $review->user_id)
                    <div class="mt-2 flex space-x-2">
                        <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                        </form>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div> 