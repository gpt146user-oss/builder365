<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Calendar Invitation - {{ $attendee->event->title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Inter', system-ui, -apple-system, sans-serif; }
        body {
            background-color: #F8FAFC;
            color: #0F172A;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 24px;
        }
        .guest-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F2;
            border-radius: 16px;
            box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.08);
            width: 100%;
            max-width: 480px;
            overflow: hidden;
        }
        .guest-header {
            background: #2563EB;
            color: #FFFFFF;
            padding: 32px 28px 24px;
        }
        .guest-header-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.18);
            color: #FFFFFF;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 4px 10px;
            border-radius: 20px;
            margin-bottom: 12px;
        }
        .guest-title {
            font-size: 22px;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 8px;
        }
        .guest-time {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .guest-body {
            padding: 28px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .guest-detail-row {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 13px;
            color: #475569;
        }
        .guest-detail-row i {
            color: #2563EB;
            font-size: 15px;
            margin-top: 2px;
            width: 16px;
            text-align: center;
        }
        .guest-detail-row strong {
            color: #0F172A;
            font-weight: 600;
        }
        .guest-status-banner {
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .status-accepted { background: #F0FDF4; color: #166534; border: 1px solid #BBF7D0; }
        .status-tentative { background: #FEFCE8; color: #854D0E; border: 1px solid #FEF08A; }
        .status-declined { background: #FEF2F2; color: #991B1B; border: 1px solid #FCA5A5; }
        .status-pending { background: #F1F5F9; color: #475569; border: 1px solid #E2E8F2; }

        .rsvp-label {
            font-size: 12px;
            font-weight: 700;
            color: #64748B;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }
        .rsvp-actions {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }
        .rsvp-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 12px 8px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 600;
            border: 1px solid #CBD5E1;
            background: #FFFFFF;
            color: #334155;
            cursor: pointer;
            transition: all .15s ease;
        }
        .rsvp-btn:hover {
            border-color: #2563EB;
            color: #2563EB;
            background: #F8FAFC;
        }
        .rsvp-btn.is-active-accepted {
            background: #22C55E;
            color: #FFFFFF;
            border-color: #22C55E;
        }
        .rsvp-btn.is-active-tentative {
            background: #EAB308;
            color: #FFFFFF;
            border-color: #EAB308;
        }
        .rsvp-btn.is-active-declined {
            background: #EF4444;
            color: #FFFFFF;
            border-color: #EF4444;
        }
        .guest-footer {
            padding: 16px 28px;
            background: #F8FAFC;
            border-top: 1px solid #F1F5F9;
            text-align: center;
            font-size: 11px;
            color: #94A3B8;
        }
    </style>
</head>
<body>
    <main class="guest-card">
        <div class="guest-header">
            <div class="guest-header-badge">
                <i class="fa-regular fa-calendar-check"></i> Calendar Invitation
            </div>
            <h1 class="guest-title">{{ $attendee->event->title }}</h1>
            <div class="guest-time">
                <i class="fa-regular fa-clock"></i>
                <span>{{ $attendee->event->starts_at->setTimezone($attendee->event->timezone)->format('D, d M Y · g:i A T') }}</span>
            </div>
        </div>

        <div class="guest-body">
            @if($attendee->event->location)
                <div class="guest-detail-row">
                    <i class="fa-solid fa-location-dot"></i>
                    <div>
                        <strong>Location</strong>
                        <div>{{ $attendee->event->location }}</div>
                    </div>
                </div>
            @endif

            @if($attendee->event->description)
                <div class="guest-detail-row">
                    <i class="fa-solid fa-align-left"></i>
                    <div>
                        <strong>Details</strong>
                        <div>{{ $attendee->event->description }}</div>
                    </div>
                </div>
            @endif

            <div class="guest-detail-row">
                <i class="fa-regular fa-envelope"></i>
                <div>
                    <strong>Invited Guest</strong>
                    <div>{{ $attendee->email }}</div>
                </div>
            </div>

            @if(session('status'))
                <div class="guest-status-banner status-{{ $attendee->response }}">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @else
                <div class="guest-status-banner status-{{ $attendee->response }}">
                    <i class="fa-solid fa-info-circle"></i>
                    <span>Current RSVP Status: <strong>{{ ucfirst($attendee->response) }}</strong></span>
                </div>
            @endif

            <div>
                <div class="rsvp-label">Update Your Response</div>
                <form method="POST" action="{{ request()->fullUrl() }}">
                    @csrf
                    <div class="rsvp-actions">
                        <button name="response" value="accepted" type="submit" class="rsvp-btn {{ $attendee->response === 'accepted' ? 'is-active-accepted' : '' }}">
                            <i class="fa-solid fa-check"></i> Accept
                        </button>
                        <button name="response" value="tentative" type="submit" class="rsvp-btn {{ $attendee->response === 'tentative' ? 'is-active-tentative' : '' }}">
                            <i class="fa-solid fa-question"></i> Tentative
                        </button>
                        <button name="response" value="declined" type="submit" class="rsvp-btn {{ $attendee->response === 'declined' ? 'is-active-declined' : '' }}">
                            <i class="fa-solid fa-xmark" aria-hidden="true"></i> Decline
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="guest-footer">
            Powered by Builder360 ERP CRM · External Guest RSVP Portal
        </div>
    </main>
</body>
</html>
