<div id="service-chat">
    <style>
        .chat-messages {
            max-height: 320px;
            overflow-y: auto;
            margin-bottom: 15px;
        }
        .chat-row {
            display: flex;
            margin-bottom: 10px;
        }
        .chat-row.me {
            justify-content: flex-end;
        }
        .chat-row.them {
            justify-content: flex-start;
        }
        .chat-bubble {
            max-width: 70%;
            padding: 10px 12px;
            border-radius: 12px;
            background: #f1f3f6;
            color: #333;
        }
        .chat-row.me .chat-bubble {
            background: #0b3b5b;
            color: #fff;
        }
        .chat-meta {
            font-size: 12px;
            color: #777;
            margin-top: 4px;
        }
        .chat-form-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 8px;
        }
    </style>
    <div class="panel panel-default" style="margin-top: 20px;">
        <div class="panel-heading">Service Messages</div>
        <div class="panel-body">
            @if(!$canView)
                <div class="alert alert-info" role="alert">
                    Please login as a customer or the service provider to send messages.
                </div>
            @else
                <div class="chat-messages">
                    @forelse($messages as $msg)
                        <div class="chat-row {{ $msg->sender_id === auth()->id() ? 'me' : 'them' }}">
                            <div class="chat-bubble">
                                <div><strong>{{ $msg->sender ? $msg->sender->name : 'User' }}</strong></div>
                                <div>{{ $msg->message }}</div>
                                <div class="chat-meta">{{ $msg->created_at }}</div>
                            </div>
                        </div>
                    @empty
                        <p>No messages yet.</p>
                    @endforelse
                </div>
                <form wire:submit.prevent="sendMessage">
                    <div class="form-group">
                        <textarea class="form-control" rows="3" wire:model="message" placeholder="Type a message..."></textarea>
                        @error('message') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>
                    <div class="chat-form-actions">
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
