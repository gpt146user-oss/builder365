<?php
    $activeFolder = $folder?->id;
    $folderIcons  = [
        'inbox'   => 'fa-inbox',
        'sent'    => 'fa-paper-plane',
        'drafts'  => 'fa-file-lines',
        'archive' => 'fa-box-archive',
        'spam'    => 'fa-shield-halved',
        'trash'   => 'fa-trash',
        'all'     => 'fa-envelope',
    ];
    $avatarColor = function (string $seed): string {
        $colors = ['#4F46E5','#F5852B','#059669','#DC2626','#D97706',
                   '#0891B2','#7C3AED','#BE185D','#C2410C','#0F766E'];
        return $colors[abs(crc32($seed)) % count($colors)];
    };
?>

<?php $__env->startSection('title', $mailboxAccount->email . ' | Mailbox'); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        /* ════════════════════════════════════════════════════════════════
        MAILBOX — ARCTIC CLARITY — COMPLETE END-TO-END
        White + Light Blue · System fonts · CSP-safe · No external CDN
        ════════════════════════════════════════════════════════════════ */

        /* ── 1. Stop page / body from scrolling ── */
        html,
        body.b360-classic { height:100%; overflow:hidden !important; }

        /* ── 2. Shell fills viewport ── */
        .b360-shell {
        height: 100vh;
        overflow: hidden;
        display: flex;
        }
        .b360-sidebar {
        flex-shrink: 0;
        height: 100vh;
        overflow-y: auto;
        overflow-x: hidden;
        }
        .b360-main {
        flex: 1;
        min-width: 0;
        height: 100vh;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        }
        .b360-topbar { flex-shrink: 0; }
        .b360-content {
        flex: 1;
        min-height: 0;
        padding: 0 !important;
        overflow: hidden !important;
        display: flex;
        flex-direction: column;
        }

        /* ════════════════════════════════
        TOKENS
        ════════════════════════════════ */
        .mbx-screen {
        --c-bg:       #F0F4FA;
        --c-surface:  #FFFFFF;
        --c-surface2: #F7F9FC;
        --c-border:   #E2E8F2;
        --c-border2:  #C7D5EA;
        --c-accent:   #F5852B;
        --c-accent-l: #EEF4FF;
        --c-accent-1: #DBEAFE;
        --c-accent-2: #BFDBFE;
        --c-accent-7: #1D4ED8;
        --c-text:     #0F172A;
        --c-text2:    #334155;
        --c-sub:      #475569;
        --c-muted:    #94A3B8;
        --c-green:    #059669;
        --c-red:      #DC2626;
        --c-amber:    #D97706;
        --c-shadow:   0 1px 3px rgba(15,23,42,.07),0 1px 2px rgba(15,23,42,.04);
        --c-shadow-m: 0 4px 16px rgba(15,23,42,.09);
        --r-sm: 8px; --r-md:10px; --r-lg:14px;
        --font: -apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif;
        }

        /* ════════════════════════════════
        THREE-PANE SCREEN
        ════════════════════════════════ */
        .mbx-screen {
        flex: 1;
        min-height: 0;
        display: flex;
        flex-direction: row;
        overflow: hidden;
        background: var(--c-bg);
        font-family: var(--font);
        font-size: 13px;
        color: var(--c-text);
        -webkit-font-smoothing: antialiased;
        }
        .mbx-screen * { box-sizing: border-box; }

        /* ════════════════════════════════
        RAIL
        ════════════════════════════════ */
        .mbx-rail {
        width: 220px;
        flex-shrink: 0;
        height: 100%;
        background: var(--c-surface);
        border-right: 1px solid var(--c-border);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        position: relative;
        z-index: 10;
        }
        /* Blue top stripe */
        .mbx-rail::before {
        content: '';
        display: block;
        height: 3px;
        flex-shrink: 0;
        background: linear-gradient(90deg,var(--c-accent),#60A5FA);
        }

        /* compose */
        .mbx-compose {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        margin: 14px 12px 10px;
        padding: 10px 16px;
        background: var(--c-accent); color: #fff;
        border: none; border-radius: var(--r-md);
        font-size: 14px; font-weight: 700; cursor: pointer;
        font-family: var(--font); text-decoration: none;
        box-shadow: 0 3px 12px rgba(37,99,235,.25);
        transition: background .14s, transform .12s;
        flex-shrink: 0;
        }
        .mbx-compose:hover { background:var(--c-accent-7); transform:translateY(-1px); color:#fff; text-decoration:none; }

        /* Account switcher */
        .mbx-acct-wrap { margin:0 10px 8px; flex-shrink:0; }
        .mbx-acct-sum {
        display: flex; align-items: center; gap: 8px;
        padding: 9px 10px;
        border: 1px solid var(--c-border); border-radius: var(--r-md);
        background: var(--c-surface2); cursor: pointer; list-style: none;
        transition: all .14s;
        }
        .mbx-acct-sum::-webkit-details-marker { display: none; }
        .mbx-acct-sum:hover { border-color:var(--c-accent-2); background:var(--c-accent-l); }
        details[open] .mbx-acct-sum { border-color:var(--c-accent-2); background:var(--c-accent-l); }
        .mbx-dot { width:8px; height:8px; border-radius:50%; background:var(--c-border2); flex-shrink:0; }
        .mbx-dot.on { background:var(--c-green); box-shadow:0 0 0 2px rgba(5,150,105,.2); }
        .mbx-ai { flex:1; min-width:0; }
        .mbx-ai strong { display:block; font-size:12.5px; font-weight:700; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; color:var(--c-text); }
        .mbx-ai small   { display:block; font-size:11px; color:var(--c-muted); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .mbx-acct-drop { margin-top:4px; background:var(--c-surface); border:1px solid var(--c-border); border-radius:var(--r-md); overflow:hidden; box-shadow:var(--c-shadow-m); }
        .mbx-acct-drop a { display:flex; align-items:center; gap:8px; padding:9px 12px; text-decoration:none; color:var(--c-text2); font-size:12.5px; border-bottom:1px solid var(--c-border); transition:background .13s; }
        .mbx-acct-drop a:last-child { border-bottom:none; }
        .mbx-acct-drop a:hover { background:var(--c-accent-l); color:var(--c-accent); text-decoration:none; }
        .mbx-acct-drop a.ia { background:var(--c-accent-l); }
        .mbx-acct-drop a.ia strong { color:var(--c-accent); }

        /* Folder nav */
        .mbx-nav { flex:1; min-height:0; overflow-y:auto; padding:4px 8px 12px; }
        .mbx-nav::-webkit-scrollbar { width:3px; }
        .mbx-nav::-webkit-scrollbar-thumb { background:var(--c-border); border-radius:3px; }
        .mbx-nav-lbl { font-size:9.5px; font-weight:800; text-transform:uppercase; letter-spacing:.1em; color:var(--c-muted); padding:12px 8px 5px; display:block; }
        .mbx-fl {
        display:flex; align-items:center; gap:9px;
        padding:8px 10px; border-radius:var(--r-md); margin:1px 0;
        text-decoration:none; color:var(--c-sub); font-size:13px; font-weight:500;
        border:1px solid transparent; transition:all .14s; position:relative; overflow:hidden;
        }
        .mbx-fl:hover { background:var(--c-accent-l); color:var(--c-text); text-decoration:none; }
        .mbx-fl.ia { background:var(--c-accent-l); color:var(--c-accent); font-weight:600; border-color:var(--c-accent-2); }
        .mbx-fl.ia::before { content:''; position:absolute; left:0; top:20%; bottom:20%; width:3px; background:var(--c-accent); border-radius:0 3px 3px 0; }
        .mbx-fl i { font-size:13px; width:16px; text-align:center; flex-shrink:0; }
        .mbx-fl span { flex:1; min-width:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .mbx-fb { margin-left:auto; background:var(--c-accent-1); color:var(--c-accent-7); font-size:10px; font-weight:700; padding:1px 7px; border-radius:10px; font-style:normal; white-space:nowrap; }
        .mbx-fb.r { background:#FEE2E2; color:var(--c-red); }

        /* Sync card */
        .mbx-sync { margin:10px 10px 0; padding:10px 12px; background:var(--c-surface2); border:1px solid var(--c-border); border-radius:var(--r-md); display:flex; align-items:center; gap:8px; flex-shrink:0; flex-wrap:wrap; }
        .mbx-sdot { width:7px; height:7px; border-radius:50%; background:var(--c-border2); flex-shrink:0; }
        .mbx-sdot.on { background:var(--c-green); }
        .mbx-scopy { flex:1; font-size:11px; color:var(--c-muted); line-height:1.3; min-width:0; }
        .mbx-sbtn { background:none; border:1px solid var(--c-accent-2); border-radius:6px; padding:3px 10px; font-size:11px; font-weight:700; color:var(--c-accent); cursor:pointer; font-family:var(--font); transition:all .14s; white-space:nowrap; }
        .mbx-sbtn:hover { background:var(--c-accent-l); }
        .mbx-serr { margin:5px 10px 8px; padding:8px 11px; background:#FEF2F2; border:1px solid #FECACA; border-radius:var(--r-sm); font-size:11px; color:var(--c-red); line-height:1.4; word-break:break-word; }

        /* ════════════════════════════════
        LIST PANE
        ════════════════════════════════ */
        .mbx-list {
        width: 320px;
        flex-shrink: 0;
        height: 100%;
        background: var(--c-surface);
        border-right: 1px solid var(--c-border);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        }

        .mbx-lhead { display:flex; align-items:center; gap:8px; padding:14px 14px 12px; border-bottom:1px solid var(--c-border); flex-shrink:0; }
        .mbx-ltitle { display:flex; align-items:center; gap:8px; flex:1; min-width:0; }
        .mbx-ltitle h1 { font-size:15px; font-weight:700; color:var(--c-text); margin:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .mbx-lcnt { font-size:10px; font-weight:700; background:var(--c-accent-1); color:var(--c-accent-7); padding:2px 8px; border-radius:20px; white-space:nowrap; }
        .mbx-refr { width:30px; height:30px; display:flex; align-items:center; justify-content:center; border:1px solid var(--c-border); border-radius:7px; background:var(--c-surface); color:var(--c-muted); text-decoration:none; font-size:12px; transition:all .14s; }
        .mbx-refr:hover { background:var(--c-accent-l); border-color:var(--c-accent-2); color:var(--c-accent); }

        .mbx-search { display:flex; align-items:center; gap:7px; margin:9px 12px 6px; padding:7px 11px; background:var(--c-surface2); border:1px solid var(--c-border); border-radius:var(--r-md); flex-shrink:0; transition:all .15s; }
        .mbx-search:focus-within { border-color:var(--c-accent); box-shadow:0 0 0 3px rgba(37,99,235,.10); background:var(--c-surface); }
        .mbx-search i { color:var(--c-muted); font-size:12px; flex-shrink:0; }
        .mbx-search input { flex:1; border:none; outline:none; background:transparent; font-size:13px; color:var(--c-text); font-family:var(--font); min-width:0; }
        .mbx-search input::placeholder { color:var(--c-muted); }
        .mbx-search input[type="hidden"] { display:none; }

        .mbx-chips { display:flex; align-items:center; gap:4px; padding:0 12px 8px; overflow-x:auto; flex-shrink:0; scrollbar-width:none; }
        .mbx-chips::-webkit-scrollbar { display:none; }
        .mbx-chip { display:inline-flex; align-items:center; gap:4px; padding:4px 11px; border-radius:20px; font-size:11.5px; font-weight:500; color:var(--c-sub); background:var(--c-surface2); border:1px solid var(--c-border); text-decoration:none; white-space:nowrap; cursor:pointer; transition:all .13s; font-family:var(--font); }
        .mbx-chip:hover { background:var(--c-accent-l); border-color:var(--c-accent-2); color:var(--c-accent); text-decoration:none; }
        .mbx-chip.on { background:var(--c-accent-l); border-color:var(--c-accent-2); color:var(--c-accent); font-weight:600; }
        .mbx-chip-wrap { position: absolute; }
        .mbx-chip-wrap summary { list-style:none; }
        .mbx-chip-wrap summary::-webkit-details-marker { display:none; }
        .mbx-chip-wrap[open] > summary > .mbx-chip { background:var(--c-accent-l); border-color:var(--c-accent-2); color:var(--c-accent); }
        .mbx-chip-drop { position:absolute; top:calc(100% + 5px); left:0; z-index:60; background:var(--c-surface); border:1px solid var(--c-border); border-radius:var(--r-lg); box-shadow:var(--c-shadow-m); min-width:150px; padding:4px; }
        .mbx-chip-drop a { display:flex; padding:8px 12px; border-radius:var(--r-sm); font-size:13px; color:var(--c-text2); text-decoration:none; transition:background .13s; }
        .mbx-chip-drop a:hover { background:var(--c-accent-l); color:var(--c-accent); }

        .mbx-rows { flex:1; min-height:0; overflow-y:auto; overflow-x:hidden; }
        .mbx-rows::-webkit-scrollbar { width:4px; }
        .mbx-rows::-webkit-scrollbar-thumb { background:var(--c-border2); border-radius:4px; }

        .mbx-row {
        display:flex; align-items:flex-start; gap:9px;
        padding:10px 12px; border-bottom:1px solid #F7F9FC;
        text-decoration:none; color:inherit; cursor:pointer;
        position:relative; transition:background .12s;
        }
        .mbx-row:hover { background:var(--c-surface2); text-decoration:none; }
        .mbx-row.on { background:var(--c-accent-l); border-left:3px solid var(--c-accent); }
        .mbx-row.unr .mbx-rsub { font-weight:700; color:var(--c-text); }
        .mbx-row.unr::after { content:''; position:absolute; top:13px; right:12px; width:6px; height:6px; border-radius:50%; background:var(--c-accent); box-shadow:0 0 0 2px rgba(37,99,235,.2); }
        .mbx-rstar { font-size:13px; color:var(--c-border2); flex-shrink:0; margin-top:2px; line-height:1; }
        .mbx-row.fl .mbx-rstar { color:var(--c-amber); }

        .mbx-av { width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; color:#fff; flex-shrink:0; text-transform:uppercase; letter-spacing:-.01em; }

        .mbx-rcopy { flex:1; min-width:0; display:flex; flex-direction:column; gap:2px; }
        .mbx-rtop { display:flex; align-items:center; justify-content:space-between; gap:6px; }
        .mbx-rfrom { font-size:13px; font-weight:600; color:var(--c-text); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .mbx-rtime { font-size:11px; color:var(--c-muted); flex-shrink:0; white-space:nowrap; }
        .mbx-rsub  { font-size:12.5px; font-weight:500; color:var(--c-sub); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .mbx-rpre  { font-size:11.5px; color:var(--c-muted); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .mbx-rtag  { display:inline-flex; align-items:center; gap:3px; font-size:10px; font-weight:600; text-transform:uppercase; letter-spacing:.04em; padding:2px 7px; border-radius:4px; background:var(--c-surface2); border:1px solid var(--c-border); color:var(--c-sub); margin-top:2px; }

        .mbx-empty { display:flex; flex-direction:column; align-items:center; justify-content:center; gap:8px; padding:48px 20px; text-align:center; }
        .mbx-empty-ic { width:48px; height:48px; border-radius:13px; background:var(--c-accent-l); display:flex; align-items:center; justify-content:center; font-size:20px; color:var(--c-accent); }
        .mbx-empty strong { font-size:14px; font-weight:700; color:var(--c-text); }
        .mbx-empty span   { font-size:13px; color:var(--c-muted); max-width:200px; line-height:1.5; }
        .mbx-lpag { padding:10px 12px; border-top:1px solid var(--c-border); flex-shrink:0; }

        /* ════════════════════════════════
        READING PANE
        ════════════════════════════════ */
        .mbx-reading {
        flex: 1;
        min-width: 0;
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow: hidden;    /* clips — does NOT scroll */
        background: var(--c-bg);
        }

        /* Subject header — pinned */
        .mbx-rh {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 15px 20px 13px;
        background: var(--c-surface);
        border-bottom: 1px solid var(--c-border);
        flex-shrink: 0;
        }
        .mbx-rh-copy { flex:1; min-width:0; }
        .mbx-msg-count { font-size:11px; color:var(--c-muted); font-weight:600; margin-bottom:3px; display:flex; align-items:center; gap:5px; }
        .mbx-rh h2 { font-size:15px; font-weight:700; color:var(--c-text); margin:0; line-height:1.35; word-break:break-word; }
        .mbx-rh-pill { display:inline-flex; align-items:center; gap:5px; font-size:11px; font-weight:700; padding:4px 11px; border-radius:20px; background:var(--c-surface2); border:1px solid var(--c-border); color:var(--c-sub); white-space:nowrap; flex-shrink:0; align-self:flex-start; margin-top:4px; }
        .mbx-rh-pill.unr { background:var(--c-accent-1); border-color:var(--c-accent-2); color:var(--c-accent-7); }
        .mbx-rh-pill.unr::before { content:''; width:6px; height:6px; border-radius:50%; background:var(--c-accent); display:inline-block; }

        /* ── Thread: THE ONLY SCROLLING REGION ── */
        .mbx-thread {
        flex: 1;
        min-height: 0;        /* ← without this, flex won't scroll */
        overflow-y: auto;
        overflow-x: hidden;
        padding: 14px 18px 16px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        -webkit-overflow-scrolling: touch;
        }
        .mbx-thread::-webkit-scrollbar       { width: 5px; }
        .mbx-thread::-webkit-scrollbar-track { background: transparent; }
        .mbx-thread::-webkit-scrollbar-thumb { background: var(--c-border2); border-radius: 4px; }
        .mbx-thread::-webkit-scrollbar-thumb:hover { background: var(--c-accent-2); }

        /* Message card */
        .mbx-card {
        background: var(--c-surface);
        border: 1px solid var(--c-border);
        border-radius: var(--r-lg);
        overflow: hidden;
        flex-shrink: 0;
        transition: box-shadow .15s;
        }
        .mbx-card:hover { box-shadow: var(--c-shadow-m); }
        .mbx-card.cur { border-color: var(--c-accent-2); box-shadow: 0 0 0 3px rgba(37,99,235,.08); }

        /* Card sender row */
        .mbx-cs {
        display:flex; align-items:center; gap:11px;
        padding:12px 16px;
        background:var(--c-surface2); border-bottom:1px solid var(--c-border);
        }
        .mbx-cs .mbx-av { width:34px; height:34px; border-radius:9px; }
        .mbx-ci { flex:1; min-width:0; }
        .mbx-ci strong { display:block; font-size:13.5px; font-weight:700; color:var(--c-text); }
        .mbx-ci small   { display:block; font-size:12px; color:var(--c-muted); margin-top:1px; }
        .mbx-ct { font-size:11.5px; color:var(--c-muted); white-space:nowrap; flex-shrink:0; }

        /* Outbox state pills */
        .mbx-sp { display:inline-flex; align-items:center; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.05em; padding:2px 8px; border-radius:20px; margin-left:8px; vertical-align:middle; }
        .sp-sent  { background:#D1FAE5; color:#065F46; border:1px solid #A7F3D0; }
        .sp-draft { background:var(--c-accent-1); color:var(--c-accent-7); border:1px solid var(--c-accent-2); }
        .sp-fail  { background:#FEE2E2; color:var(--c-red); border:1px solid #FECACA; }
        .sp-sched { background:#FEF3C7; color:#92400E; border:1px solid #FDE68A; }

        /* Card body */
        .mbx-cb { padding:16px 18px; }
        .mbx-plain { font-size:14px; line-height:1.75; color:var(--c-text2); white-space:pre-wrap; word-break:break-word; overflow-wrap:break-word; }
        /* HTML email host */
        .b360-email-shadow-host { min-height:60px; overflow:hidden; width:100%; max-width:100%; }
        .b360-email-tpl { display:none; }
        .b360-email-fallback { font-size:14px; line-height:1.75; color:var(--c-text2); overflow-wrap:break-word; }
        .b360-email-fallback img { max-width:100%; height:auto; }

        /* Card attachments */
        .mbx-ca { padding:10px 16px 13px; border-top:1px solid var(--c-border); display:flex; flex-wrap:wrap; gap:6px; align-items:flex-start; }
        .mbx-ca > strong { width:100%; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:var(--c-muted); margin-bottom:2px; }
        .mbx-ca a { display:inline-flex; align-items:center; gap:6px; padding:5px 12px; background:var(--c-accent-l); border:1px solid var(--c-accent-2); border-radius:var(--r-sm); font-size:12px; font-weight:500; color:var(--c-accent); text-decoration:none; transition:background .13s; }
        .mbx-ca a:hover { background:var(--c-accent-1); }

        /* ── Action footer — ALWAYS PINNED ── */
        .mbx-af {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
        padding: 10px 16px;
        background: var(--c-surface);
        border-top: 1px solid var(--c-border);
        flex-shrink: 0;
        min-height: 54px;
        }
        .mbx-af form { margin: 0; }

        /* Buttons */
        .mbx-btn {
        display:inline-flex; align-items:center; gap:6px;
        padding:7px 14px; border-radius:var(--r-sm);
        border:1px solid var(--c-border); background:var(--c-surface);
        font-size:13px; font-weight:500; color:var(--c-text2);
        cursor:pointer; font-family:var(--font); text-decoration:none;
        transition:all .14s; white-space:nowrap;
        }
        .mbx-btn:hover { background:var(--c-accent-l); border-color:var(--c-accent-2); color:var(--c-accent); text-decoration:none; }
        .mbx-btn i { font-size:11px; }
        .mbx-btn.pri { background:var(--c-accent); color:#fff; border-color:var(--c-accent); font-weight:600; box-shadow:0 2px 8px rgba(37,99,235,.22); }
        .mbx-btn.pri:hover { background:var(--c-accent-7); border-color:var(--c-accent-7); color:#fff; box-shadow:0 4px 14px rgba(37,99,235,.30); }
        .mbx-btn.danger { color:var(--c-red); border-color:#FECACA; background:#FFF5F5; }
        .mbx-btn.danger:hover { background:#FEE2E2; border-color:#FCA5A5; color:var(--c-red); }

        /* Empty reading state */
        .mbx-rempty { flex:1; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:10px; padding:40px; text-align:center; }
        .mbx-rempty-ic { width:60px; height:60px; border-radius:16px; background:var(--c-accent-l); border:1px solid var(--c-accent-2); display:flex; align-items:center; justify-content:center; font-size:26px; color:var(--c-accent); }
        .mbx-rempty strong { font-size:15px; font-weight:700; color:var(--c-text); }
        .mbx-rempty span   { font-size:13px; color:var(--c-muted); max-width:240px; line-height:1.6; }

        /* ════════════════════════════════
        RESPONSIVE
        ════════════════════════════════ */
        @media (max-width:1280px) {
        .mbx-list { width:290px; }
        .mbx-rail { width:200px; }
        }
        @media (max-width:1024px) {
        .mbx-reading:not(.visible) { display:none; }
        .mbx-list { width:auto; flex:1; border-right:none; }
        .mbx-rail { width:185px; }
        }
        @media (max-width:768px) {
        .mbx-rail { display:none; }
        .mbx-screen.has-msg .mbx-list    { display:none; }
        .mbx-screen.has-msg .mbx-reading { display:flex; }
        .mbx-reading { width:100%; }
        }

        /* Accessibility */
        .sr-only { position:absolute; width:1px; height:1px; padding:0; margin:-1px; overflow:hidden; clip:rect(0,0,0,0); white-space:nowrap; border:0; }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="mbx-screen <?php echo e($selected ? 'has-msg' : ''); ?>" aria-label="Mailbox">

  
  <aside class="mbx-rail">

    
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('send', $mailboxAccount)): ?>
      <a class="mbx-compose"
         href="<?php echo e(route('mailbox.external.show', [$mailboxAccount, 'compose' => 'new'])); ?>">
        <i class="fa-solid fa-pen" aria-hidden="true"></i> Compose
      </a>
    <?php endif; ?>

    
    <details class="mbx-acct-wrap" >
      <summary class="mbx-acct-sum">
        <span class="mbx-dot <?php echo e($mailboxAccount->status === 'active' ? 'on' : ''); ?>"></span>
        <div class="mbx-ai">
          <strong><?php echo e($mailboxAccount->name); ?></strong>
          <small><?php echo e($mailboxAccount->email); ?></small>
        </div>
        <i class="fa-solid fa-chevron-down" style="font-size:10px;color:var(--c-muted)" aria-hidden="true"></i>
      </summary>
      <nav class="mbx-acct-drop" aria-label="Switch account">
        <?php $__currentLoopData = $availableAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $acct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <a href="<?php echo e(route('mailbox.external.show', $acct)); ?>"
             class="<?php echo e($acct->is($mailboxAccount) ? 'ia' : ''); ?>">
            <span class="mbx-dot <?php echo e($acct->status === 'active' ? 'on' : ''); ?>"></span>
            <div class="mbx-ai">
              <strong><?php echo e($acct->name); ?></strong>
              <small><?php echo e($acct->email); ?></small>
            </div>
            <?php if($acct->is($mailboxAccount)): ?>
              <i class="fa-solid fa-check" style="font-size:11px;color:var(--c-accent);margin-left:auto" aria-hidden="true"></i>
            <?php endif; ?>
          </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('mailbox.accounts.index')); ?>">
          <i class="fa-solid fa-gear" style="font-size:12px;color:var(--c-muted)" aria-hidden="true"></i>
          <div class="mbx-ai"><strong>Manage accounts</strong></div>
        </a>
      </nav>
    </details>

    
    <nav class="mbx-nav" aria-label="Email folders">
      <span class="mbx-nav-lbl">Mailbox</span>

      <?php $__currentLoopData = $mailboxAccount->folders->sortBy(fn($f) => $f->special_use === 'inbox' ? 0 : 1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $uc = $f->emails()->where('is_deleted', false)->where('is_read', false)->count(); ?>
        <a href="<?php echo e(route('mailbox.external.show', [$mailboxAccount, 'folder' => $f->id])); ?>"
           class="mbx-fl <?php echo e($activeFolder === $f->id ? 'ia' : ''); ?>"
           <?php if($activeFolder === $f->id): ?> aria-current="page" <?php endif; ?>>
          <i class="fa-solid <?php echo e($folderIcons[$f->special_use] ?? 'fa-folder'); ?>" aria-hidden="true"></i>
          <span><?php echo e($f->name); ?></span>
          <?php if($uc): ?><em class="mbx-fb"><?php echo e(number_format($uc)); ?></em><?php endif; ?>
        </a>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('send', $mailboxAccount)): ?>
        <?php $dc = $mailboxAccount->outboxMessages()->where('user_id', auth()->id())->whereIn('state', ['draft','scheduled','failed'])->count(); ?>
        <a href="<?php echo e(route('mailbox.drafts.index', $mailboxAccount)); ?>" class="mbx-fl">
          <i class="fa-solid fa-file-pen" aria-hidden="true"></i>
          <span>Drafts & scheduled</span>
          <?php if($dc): ?><em class="mbx-fb"><?php echo e($dc); ?></em><?php endif; ?>
        </a>
      <?php endif; ?>
    </nav>

    
    <div class="mbx-sync">
      <span class="mbx-sdot <?php echo e($mailboxAccount->status === 'active' ? 'on' : ''); ?>"></span>
      <span class="mbx-scopy">
        <?php echo e($mailboxAccount->last_synced_at
            ? 'Synced ' . $mailboxAccount->last_synced_at->diffForHumans()
            : 'Not synced yet'); ?>

      </span>
      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $mailboxAccount)): ?>
        <form method="POST" action="<?php echo e(route('mailbox.accounts.sync', $mailboxAccount)); ?>">
          <?php echo csrf_field(); ?>
          <button type="submit" class="mbx-sbtn">Sync now</button>
        </form>
      <?php endif; ?>
    </div>
    <?php if($mailboxAccount->last_sync_error): ?>
      <p class="mbx-serr"><?php echo e($mailboxAccount->last_sync_error); ?></p>
    <?php endif; ?>

  </aside>


  
  <section class="mbx-list">

    <header class="mbx-lhead">
      <div class="mbx-ltitle">
        <i class="fa-solid <?php echo e($folderIcons[$folder?->special_use ?? 'all'] ?? 'fa-envelope'); ?>"
           style="font-size:15px;color:var(--c-muted)" aria-hidden="true"></i>
        <h1><?php echo e($folder?->name ?? 'Mailbox'); ?></h1>
        <span class="mbx-lcnt"><?php echo e(number_format($emails->total())); ?></span>
      </div>
      <a class="mbx-refr" href="<?php echo e(request()->fullUrl()); ?>" aria-label="Refresh">
        <i class="fa-solid fa-rotate-right" aria-hidden="true"></i>
      </a>
    </header>

    <form class="mbx-search" method="GET" role="search">
      <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
      <input type="search" name="q"
             value="<?php echo e(request('q')); ?>"
             placeholder="Search sender, subject…"
             aria-label="Search messages">
      <input type="hidden" name="folder" value="<?php echo e($activeFolder); ?>">
    </form>

    <nav class="mbx-chips" aria-label="Message filters">
      <a class="mbx-chip <?php echo e(request()->boolean('unread') ? 'on' : ''); ?>"
         href="<?php echo e(route('mailbox.external.show', [$mailboxAccount, 'folder' => $activeFolder, 'unread' => 1])); ?>">
        Unread
      </a>
      <a class="mbx-chip <?php echo e(request()->boolean('flagged') ? 'on' : ''); ?>"
         href="<?php echo e(route('mailbox.external.show', [$mailboxAccount, 'folder' => $activeFolder, 'flagged' => 1])); ?>">
        Starred
      </a>
      <a class="mbx-chip <?php echo e(request()->boolean('attachments') ? 'on' : ''); ?>"
         href="<?php echo e(route('mailbox.external.show', [$mailboxAccount, 'folder' => $activeFolder, 'attachments' => 1])); ?>">
        Attachments
      </a>
      <details class="mbx-chip-wrap">
        <summary>
          <span class="mbx-chip">
            Sort <i class="fa-solid fa-chevron-down" style="font-size:9px" aria-hidden="true"></i>
          </span>
        </summary>
        <div class="mbx-chip-drop">
          <?php $__currentLoopData = ['newest' => 'Newest first', 'oldest' => 'Oldest first', 'subject' => 'Subject', 'sender' => 'Sender']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s => $sl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('mailbox.external.show', [$mailboxAccount, 'folder' => $activeFolder, 'sort' => $s])); ?>"><?php echo e($sl); ?></a>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </details>
      <a class="mbx-chip"
         href="<?php echo e(route('mailbox.external.show', [$mailboxAccount, 'folder' => $activeFolder])); ?>">
        Clear
      </a>
    </nav>

    <div class="mbx-rows">
      <?php $__empty_1 = true; $__currentLoopData = $emails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $email): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php
          $from  = collect($email->from_addresses ?? [])->first();
          $fname = $from['name'] ?? $from['email'] ?? 'Unknown';
          $femail= $from['email'] ?? '';
          $init  = strtoupper(mb_substr($fname, 0, 2));
          $col   = $avatarColor($femail ?: $fname);
          $cls   = implode(' ', array_filter([
            'mbx-row',
            $selected?->id === $email->id ? 'on'  : '',
            !$email->is_read              ? 'unr' : '',
            $email->is_flagged            ? 'fl'  : '',
          ]));
          /* Strip HTML tags for preview */
          $preview = $email->text_body
            ? str($email->text_body)->squish()->limit(65)
            : str(strip_tags($email->html_body ?? ''))->squish()->limit(65);
        ?>
        <a class="<?php echo e($cls); ?>"
           href="<?php echo e(route('mailbox.external.show', [$mailboxAccount,
               'folder'  => $activeFolder,
               'message' => $email->id,
           ] + request()->only(['q', 'sort', 'unread', 'flagged', 'attachments']))); ?>"
           aria-label="<?php echo e($email->subject ?: 'No subject'); ?> from <?php echo e($fname); ?>">
          <span class="mbx-rstar" aria-hidden="true"><?php echo e($email->is_flagged ? '★' : '☆'); ?></span>
          <span class="mbx-av" style="background:<?php echo e($col); ?>" aria-hidden="true"><?php echo e($init); ?></span>
          <span class="mbx-rcopy">
            <span class="mbx-rtop">
              <strong class="mbx-rfrom"><?php echo e($fname); ?></strong>
              <time class="mbx-rtime"
                    datetime="<?php echo e($email->received_at?->toIso8601String()); ?>">
                <?php echo e($email->received_at?->isToday()
                    ? $email->received_at->format('h:i A')
                    : ($email->received_at?->isYesterday()
                        ? 'Yesterday'
                        : $email->received_at?->format('d M'))); ?>

              </time>
            </span>
            <div class="mbx-rsub"><?php echo e($email->subject ?: '(No subject)'); ?></div>
            <small class="mbx-rpre"><?php echo e($preview); ?></small>
            <?php if($email->has_attachments): ?>
              <span class="mbx-rtag">
                <i class="fa-solid fa-paperclip" style="font-size:9px" aria-hidden="true"></i>
                Attachment
              </span>
            <?php endif; ?>
          </span>
        </a>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="mbx-empty">
          <div class="mbx-empty-ic"><i class="fa-regular fa-envelope" aria-hidden="true"></i></div>
          <strong>This folder is empty</strong>
          <span>Synchronize the account or adjust your filters.</span>
        </div>
      <?php endif; ?>
    </div>

    <?php if($emails->hasPages()): ?>
      <div class="mbx-lpag"><?php echo e($emails->links()); ?></div>
    <?php endif; ?>

  </section>


  
  <section class="mbx-reading <?php echo e($selected ? 'visible' : ''); ?>" aria-label="Email reading pane">

    <?php if($selected): ?>

      
      <header class="mbx-rh">
        <div class="mbx-rh-copy">
          <div class="mbx-msg-count">
            <i class="fa-regular fa-comments" style="font-size:12px" aria-hidden="true"></i>
            <?php echo e($threadMessages->count()); ?> <?php echo e(str('message')->plural($threadMessages->count())); ?>

          </div>
          <h2><?php echo e($selected->subject ?: '(No subject)'); ?></h2>
        </div>
        <span class="mbx-rh-pill <?php echo e($selected->is_read ? '' : 'unr'); ?>">
          <?php echo e($selected->is_read ? 'Read' : 'Unread'); ?>

        </span>
      </header>

      
      <div class="mbx-thread" role="list" aria-label="Message thread">

        <?php $__currentLoopData = $threadMessages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php
            $isOut = $msg instanceof \App\Models\MailboxOutboxMessage;

            if ($isOut) {
              $sn  = $msg->account?->name ?? 'Me';
              $se  = $msg->account?->email ?? '';
              $st  = $msg->sent_at ?? $msg->updated_at;
              $to  = collect($msg->to_addresses ?? [])
                       ->map(fn($a) => $a['name'] ?? $a['email'] ?? $a)
                       ->filter()->join(', ');
              $spCls = 'sp-' . ($msg->state ?? 'draft');
              $spLbl = ucfirst($msg->state ?? 'draft');
            } else {
              $tf  = collect($msg->from_addresses ?? [])->first();
              $sn  = $tf['name']  ?? $tf['email'] ?? 'Unknown';
              $se  = $tf['email'] ?? '';
              $st  = $msg->received_at;
            }

            $si  = strtoupper(mb_substr($sn, 0, 2));
            $sc  = $avatarColor($se ?: $sn);

            /* Sanitise HTML body */
            $sh = null;
            if ($msg->html_body) {
              $sh = preg_replace([
                '/<script\b[^>]*>.*?<\/script>/is',
                '/<link\b[^>]*\brel=["\']?stylesheet["\']?[^>]*>/i',
                '/\s+on\w+\s*=\s*(?:"[^"]*"|\'[^\']*\')/i',
                '/<base\b[^>]*>/i',
                '/(<\/?)(?:html|head|body)\b([^>]*>)/i',
                '/<\/template>/i',
              ], ['','','','','$1div$2','&lt;/template&gt;'],
              $msg->html_body);
            }
          ?>

          <article class="mbx-card <?php echo e($msg->id === $selected->id ? 'cur' : ''); ?>"
                   role="listitem"
                   data-message-id="<?php echo e($msg->id); ?>">

            
            <div class="mbx-cs">
              <span class="mbx-av" style="background:<?php echo e($sc); ?>" aria-hidden="true"><?php echo e($si); ?></span>
              <div class="mbx-ci">
                <strong>
                  <?php echo e($isOut ? 'Me (' . $se . ')' : $sn); ?>

                  <?php if($isOut): ?>
                    <span class="mbx-sp <?php echo e($spCls); ?>"><?php echo e($spLbl); ?></span>
                  <?php endif; ?>
                </strong>
                <small><?php echo e(($isOut && !empty($to)) ? 'To: ' . $to : $se); ?></small>
              </div>
              <time class="mbx-ct" datetime="<?php echo e($st?->toIso8601String()); ?>">
                <?php echo e($st?->format('d M Y, h:i A')); ?>

              </time>
            </div>

            
            <div class="mbx-cb">
              <?php if($sh): ?>
                <template class="b360-email-tpl"><?php echo $sh; ?></template>
                <div class="b360-email-shadow-host" aria-label="Email content">
                  <?php if($msg->text_body): ?>
                    <div class="b360-email-fallback">
                      <?php echo nl2br(e(str($msg->text_body)->limit(3000))); ?>

                    </div>
                  <?php else: ?>
                    <div class="b360-email-fallback" style="white-space:normal"><?php echo $sh; ?></div>
                  <?php endif; ?>
                </div>
              <?php elseif($msg->text_body): ?>
                <div class="mbx-plain"><?php echo nl2br(e($msg->text_body)); ?></div>
              <?php else: ?>
                <p style="color:var(--c-muted);font-style:italic;font-size:13px;margin:0">
                  No message body.
                </p>
              <?php endif; ?>
            </div>

            
            <?php if($msg->attachments?->isNotEmpty()): ?>
              <div class="mbx-ca">
                <strong>Attachments</strong>
                <?php $__currentLoopData = $msg->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $att): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <a href="<?php echo e(route('mailbox.attachments.download', $att)); ?>">
                    <i class="fa-solid fa-paperclip" style="font-size:11px" aria-hidden="true"></i>
                    <?php echo e($att->filename ?? $att->original_filename ?? 'File'); ?>

                  </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            <?php endif; ?>

          </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

      </div>

      
      <footer class="mbx-af">

        <?php if(!($isOutboxFolder ?? false)): ?>
          
          <form method="POST" action="<?php echo e(route('mailbox.external.state', $selected)); ?>">
            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
            <input type="hidden" name="action" value="<?php echo e($selected->is_read ? 'unread' : 'read'); ?>">
            <button type="submit" class="mbx-btn">
              <i class="fa-regular <?php echo e($selected->is_read ? 'fa-envelope' : 'fa-envelope-open'); ?>" aria-hidden="true"></i>
              Mark <?php echo e($selected->is_read ? 'unread' : 'read'); ?>

            </button>
          </form>

          
          <form method="POST" action="<?php echo e(route('mailbox.external.state', $selected)); ?>">
            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
            <input type="hidden" name="action" value="<?php echo e($selected->is_flagged ? 'unstar' : 'star'); ?>">
            <button type="submit" class="mbx-btn">
              <i class="fa-<?php echo e($selected->is_flagged ? 'solid' : 'regular'); ?> fa-star"
                 style="<?php echo e($selected->is_flagged ? 'color:var(--c-amber)' : ''); ?>" aria-hidden="true"></i>
              <?php echo e($selected->is_flagged ? 'Remove star' : 'Star'); ?>

            </button>
          </form>

          
          <?php $__currentLoopData = ['archive' => ['Archive','fa-box-archive',''], 'spam' => ['Spam','fa-shield-halved',''], 'trash' => ['Delete','fa-trash','danger']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $act => [$lbl, $icon, $cls]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($mailboxAccount->folders->contains('special_use', $act)): ?>
              <form method="POST" action="<?php echo e(route('mailbox.external.state', $selected)); ?>">
                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                <input type="hidden" name="action" value="<?php echo e($act); ?>">
                <button type="submit" class="mbx-btn <?php echo e($cls); ?>">
                  <i class="fa-solid <?php echo e($icon); ?>" aria-hidden="true"></i> <?php echo e($lbl); ?>

                </button>
              </form>
            <?php endif; ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

          
          <?php if(in_array($selected->folder?->special_use, ['trash','spam'], true)
              && $mailboxAccount->folders->contains('special_use', 'inbox')): ?>
            <form method="POST" action="<?php echo e(route('mailbox.external.state', $selected)); ?>">
              <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
              <input type="hidden" name="action" value="inbox">
              <button type="submit" class="mbx-btn">
                <i class="fa-solid fa-inbox" aria-hidden="true"></i> Restore
              </button>
            </form>
          <?php endif; ?>
        <?php endif; ?>

        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('send', $mailboxAccount)): ?>
          <?php if(!($isOutboxFolder ?? false)): ?>
            <a class="mbx-btn pri"
               href="<?php echo e(route('mailbox.external.show', [$mailboxAccount,
                   'folder'          => $activeFolder,
                   'message'         => $selected->id,
                   'compose'         => 'reply',
                   'compose_message' => $selected->id,
               ])); ?>">
              <i class="fa-solid fa-reply" aria-hidden="true"></i> Reply
            </a>
            <a class="mbx-btn"
               href="<?php echo e(route('mailbox.external.show', [$mailboxAccount,
                   'folder'          => $activeFolder,
                   'message'         => $selected->id,
                   'compose'         => 'reply_all',
                   'compose_message' => $selected->id,
               ])); ?>">
              Reply all
            </a>
            <a class="mbx-btn"
               href="<?php echo e(route('mailbox.external.show', [$mailboxAccount,
                   'folder'          => $activeFolder,
                   'message'         => $selected->id,
                   'compose'         => 'forward',
                   'compose_message' => $selected->id,
               ])); ?>">
              Forward
            </a>
          <?php endif; ?>
        <?php endif; ?>

      </footer>

    <?php else: ?>

      <div class="mbx-rempty" role="status">
        <div class="mbx-rempty-ic" aria-hidden="true">
          <i class="fa-regular fa-envelope-open"></i>
        </div>
        <strong>Select a message</strong>
        <span>Choose an email from the list to read the conversation.</span>
      </div>

    <?php endif; ?>

  </section>

</section>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('send', $mailboxAccount)): ?>
  <?php if(($composeData['open'] ?? false) || $composeDraft || $errors->any()): ?>
    <?php echo $__env->make('mailbox.external.partials.compose', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  <?php endif; ?>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/b360-mailbox.js')); ?>" defer></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\mailbox\external\show.blade.php ENDPATH**/ ?>