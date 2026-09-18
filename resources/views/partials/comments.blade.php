<section id="comments" class="px-6 py-16">
    <div class="mx-auto max-w-3xl">
        <h2 class="section-heading mx-auto text-center text-2xl uppercase text-[#fff7a0] sm:text-3xl">Guestbook</h2>
        <p class="mt-3 text-center font-body text-lg text-[#83769c]">Tinggalkan komentar bareng karakter pilihanmu.</p>

        <div class="rpg-panel relative mt-10 p-8">
            @include('partials.corners')

            <form id="comment-form" class="space-y-4">
                <div class="flex items-center gap-3">
                    <span class="comment-form-avatar" id="comment-form-avatar"></span>
                    <div class="flex-1">
                        <label for="comment-name" class="block font-display text-xs uppercase tracking-widest text-[#83769c]">Nama</label>
                        <input type="text" id="comment-name" name="name" maxlength="60" required
                               class="mt-2 w-full border-2 border-[#ffec27]/30 bg-[#0b0b14] px-4 py-2.5 font-body text-lg text-[#fff1e8] outline-none focus:border-[#ffec27] focus:shadow-[3px_3px_0_0_#ffec27]">
                    </div>
                </div>

                <div>
                    <label for="comment-message" class="block font-display text-xs uppercase tracking-widest text-[#83769c]">Komentar</label>
                    <textarea id="comment-message" name="message" rows="3" maxlength="500" required
                              class="mt-2 w-full border-2 border-[#ffec27]/30 bg-[#0b0b14] px-4 py-2.5 font-body text-lg text-[#fff1e8] outline-none focus:border-[#ffec27] focus:shadow-[3px_3px_0_0_#ffec27]"></textarea>
                </div>

                <p id="comment-error" class="hidden text-xs text-[#ff77a8]"></p>

                <button type="submit" class="btn-quest btn-primary px-6 py-3 text-sm uppercase">
                    Kirim Komentar &rarr;
                </button>
            </form>

            <ul id="comment-list" class="comment-list">
                @forelse ($comments ?? [] as $comment)
                    <li class="comment-item">
                        <span class="comment-avatar"><x-character-icon :name="$comment->character" class="h-8 w-8" /></span>
                        <div class="comment-body">
                            <div class="comment-meta">
                                <span class="comment-name font-display">{{ $comment->name }}</span>
                                <span class="comment-time">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="comment-message font-body">{{ $comment->message }}</p>
                        </div>
                    </li>
                @empty
                    <li id="comment-empty" class="comment-empty font-body">Belum ada komentar. Jadilah yang pertama!</li>
                @endforelse
            </ul>
        </div>
    </div>
</section>

<template id="tpl-comment-icon-knight"><x-character-icon name="knight" class="h-8 w-8" /></template>
<template id="tpl-comment-icon-princess"><x-character-icon name="princess" class="h-8 w-8" /></template>
<template id="tpl-comment-icon-dragon"><x-character-icon name="dragon" class="h-8 w-8" /></template>
