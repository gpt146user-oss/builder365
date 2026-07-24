<div class="b360-thread-timeline" x-ref="timeline" aria-live="polite">
    @forelse ($chatMessages as $message)
        @php
            $isMine = (int) $message->sender_user_id === (int) auth()->id();
            $reactionGroups = $message->reactions->groupBy('emoji');
            $otherReads = $message->reads->where('user_id', '!=', auth()->id());
            $allRead = $otherReads->isNotEmpty() && $otherReads->every(fn ($read) => $read->read_at !== null);
        @endphp
        <article class="b360-thread-message {{ $isMine ? 'is-mine' : '' }}" data-message-id="{{ $message->id }}">
            <x-ui.user-avatar :user="$message->sender" :label="$message->sender?->name ?? 'System'" class="b360-message-avatar" />
            <div class="b360-message-content">
                
                @if ($message->parent)
                    <div class="b360-chat-reply">
                        <strong>{{ $message->parent->sender?->name ?? 'Message' }}</strong>
                        <span>{{ str($message->parent->body)->squish()->limit(90) }}</span>
                    </div>
                @endif

                @if ($message->body)
                    <div class="b360-message-bubble">{{ $message->body }}</div>
                @endif

                @foreach ($message->attachments ?? [] as $attachment)
                    <div class="b360-chat-attachment {{ $attachment->scan_status === 'blocked' ? 'is-blocked' : '' }}">
                        @if ($attachment->scan_status === 'blocked')
                            <strong>Attachment unavailable</strong>
                            <small>This file did not pass the security check.</small>
                        @else
                            @if (str_starts_with((string) $attachment->mime_type, 'image/'))
                                <a href="{{ route('collaboration.chat.attachments.preview', $attachment) }}" target="_blank" rel="noopener">
                                    <img src="{{ route('collaboration.chat.attachments.preview', $attachment) }}" alt="{{ $attachment->original_filename }}">
                                </a>
                            @endif
                            <a href="{{ route('collaboration.chat.attachments.download', $attachment) }}">{{ $attachment->original_filename }}</a>
                            <small>{{ number_format(((int) $attachment->size_bytes) / 1024, 1) }} KB</small>
                        @endif
                    </div>
                @endforeach

                @if ($message->poll)
                    <div class="b360-chat-poll">
                        <strong>{{ $message->poll->question }}</strong>
                        @if ($message->poll->status === 'open')
                            <form method="POST" action="{{ route('collaboration.chat.polls.votes.store', $message->poll) }}" x-on:submit.prevent="submitTimelineAction">
                                @csrf
                                @foreach ($message->poll->options as $option)
                                    <label>
                                        <input type="{{ $message->poll->allows_multiple ? 'checkbox' : 'radio' }}" name="option_ids[]" value="{{ $option->id }}" @required(! $message->poll->allows_multiple)>
                                        <span>{{ $option->option_text }}</span>
                                        <small>{{ $option->votes?->count() ?? 0 }}</small>
                                    </label>
                                @endforeach
                                <button class="b360-small-btn" type="submit">Vote</button>
                            </form>
                            @if ((int) $message->poll->created_by_user_id === (int) auth()->id())
                                <form method="POST" action="{{ route('collaboration.chat.polls.close', $message->poll) }}" x-on:submit.prevent="submitTimelineAction">
                                    @csrf
                                    @method('PATCH')
                                    <button class="b360-small-btn" type="submit">Close poll</button>
                                </form>
                            @endif
                        @else
                            <span class="blade-status-pill">Closed</span>
                        @endif
                    </div>
                @endif
                <header>
                    <strong>{{ $message->sender?->name ?? 'System' }}</strong>
                    <small>{{ $message->created_at?->format('h:i A') }}</small>
                </header>

                @if ($reactionGroups->isNotEmpty())
                    <div class="b360-chat-reaction-summary">
                        @foreach ($reactionGroups as $emoji => $rows)
                            <span>{{ $emoji }} {{ $rows->count() }}</span>
                        @endforeach
                    </div>
                @endif

                
                <footer class="b360-chat-message-actions" aria-label="Message reactions">
                    <button
                        type="button"
                        class="b360-chat-reply-action"
                        data-message-id="{{ $message->id }}"
                        data-message-label="{{ $message->message_number }}"
                        x-on:click="selectReply"
                        aria-label="Reply to {{ $message->message_number }}"
                        title="Reply"
                    ><i class="fa-solid fa-reply" aria-hidden="true"></i></button>
                    @foreach (['👍', '❤️', '✅'] as $emoji)
                        <form method="POST" action="{{ route('collaboration.chat.messages.reactions.update', $message) }}" x-on:submit.prevent="submitTimelineAction">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="emoji" value="{{ $emoji }}">
                            <input type="hidden" name="action" value="toggle">
                            <button type="submit" aria-label="React {{ $emoji }}">{{ $emoji }}</button>
                        </form>
                    @endforeach
                    @if ($isMine)
                        <span class="b360-chat-read-state" title="{{ $allRead ? 'Read' : 'Delivered' }}">{{ $allRead ? '✓✓' : '✓' }}</span>
                    @endif
                </footer>
            </div>
        </article>
    @empty
        <div class="b360-collab-empty b360-collab-empty-large">
            <strong>No messages yet</strong>
            <span>Send the first message in this conversation.</span>
        </div>
    @endforelse
</div>

