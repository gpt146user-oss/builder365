<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasColumn('mailbox_outbox_messages', 'thread_key')) {
            Schema::table('mailbox_outbox_messages', function (Blueprint $table): void {
                $table->string('thread_key', 64)->nullable()->after('in_reply_to')->index();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('mailbox_outbox_messages', 'thread_key')) {
            Schema::table('mailbox_outbox_messages', function (Blueprint $table): void {
                $table->dropColumn('thread_key');
            });
        }
    }
};
