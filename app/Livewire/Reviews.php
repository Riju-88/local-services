<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Review;
use App\Models\Provider;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Reviews extends Component
{
    use WithFileUploads;

    public $photoUploads = [];
    public $providerId;
    public $provider;
    public $reviews;
    public $rating, $title, $comment, $photos = [];
    public $editingReviewId = null;
    public $showForm = false;


    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'title' => 'required|string|max:255',
        'comment' => 'required|string',
        'photoUploads.*' => 'image|max:3072', // max 3MB per file
    ];

    public function mount($providerId)
    {
        $this->providerId = $providerId;
    $this->provider = Provider::findOrFail($providerId);
    $this->loadReviews();
    }

    public function loadReviews()
    {
        $this->reviews = $this->provider->reviews()->latest()->get();
    }

    public function save()
    {
        $this->validate();

          $savedPhotos = [];
    foreach ($this->photoUploads as $photo) {
        $savedPhotos[] = $photo->store('reviews', 'public');
    }

        if ($this->editingReviewId) {
            $review = Review::findOrFail($this->editingReviewId);
            $review->update([
                'rating' => $this->rating,
                'title' => $this->title,
                'comment' => $this->comment,
                'photos' => $savedPhotos,
            ]);
        } else {
            $this->provider->reviews()->create([
                'user_id' => Auth::id(),
                'rating' => $this->rating,
                'title' => $this->title,
                'comment' => $this->comment,
                'photos' => $savedPhotos,
            ]);
        }

        $this->resetFields();
        $this->loadReviews();
    }

    public function edit($id)
    {
        $review = Review::findOrFail($id);
        $this->editingReviewId = $review->id;
        $this->rating = $review->rating;
        $this->title = $review->title;
        $this->comment = $review->comment;
        $this->photos = $review->photos ?? [];

    }

   public function delete($id)
{
    $review = Review::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    // Delete associated photos from storage
    if (!empty($review->photos)) {
        foreach ($review->photos as $photo) {
            Storage::disk('public')->delete($photo);
        }
    }

    // Delete the review itself
    $review->delete();

    $this->loadReviews();
}

#[On('review-form-reset')]
 public function resetFields()
{
    $this->rating = '';
    $this->title = '';
    $this->comment = '';
    // DO NOT reset $photos here — keep it intact so photos stay visible
    $this->photoUploads = [];
    $this->editingReviewId = null;
    
}


     public function removePhoto($index)
    {
        if (isset($this->photos[$index])) {
            // Delete actual file
            Storage::disk('public')->delete($this->photos[$index]);

            // Remove from photos array
            array_splice($this->photos, $index, 1);
        }
    }

    public function render()
    {
        return view('livewire.reviews');
    }
}