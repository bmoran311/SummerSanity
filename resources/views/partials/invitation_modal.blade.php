<!-- Invitation Modal -->
<div id="invitation-modal-overlay" class="modal-overlay hide">
    <div class="card modal invitation-modal">
        <div class="gradient"></div>
        <div class="close-btn"><img src="/assets/icons/close.svg" /></div>
        <div class="header">
            <img src="/assets/icons/register.svg" alt="Register Icon" />
            <h4>Invite & Simplify Summer Together!</h4>
            <p>Send an invite to friends and family to share schedules and plan activities.</p>
        </div>
        <div class="modal__main">
            <div class="left">
                <form id="invite-email-form" method="POST" action="{{ route('send-invites') }}">
                    @csrf
                    <label class="field__label" for="emails">Enter friends’ emails (comma-separated)</label>
                    <div class="input__field">
                        <img src="/assets/icons/email.svg" alt="Profile icon" />
                        <input type="text" placeholder="friend1@example.com, friend2@example.com" name="emails" id="emails" class="input__email" />
                        <button type="submit" class="btn btn--sm">Send</button>
                    </div>
                </form>
                <div class="line-separator"></div>
                <!-- Invite History -->
                <div class="invite-history-container">
                    <div class="field__label">Invite History</div>
                    <div class="invites-list">
                        @foreach($friends as $friend)
                            <div class="invite-item">
                                <div class="invite-item__main">
                                    <span class="name">{{ $friend->first_name }} {{ $friend->last_name }} </span>
                                    <span class="email">{{ $friend->email }}</span>
                                </div>
                                <div class="state">Accepted</div>
                            </div>
                        @endforeach
                        @if($pending_invitations->isNotEmpty())
                            @foreach($pending_invitations as $invite)
                                <div class="invite-item">
                                    <div class="invite-item__main">
                                        <span class="email">{{ $invite->email }}</span>
                                    </div>
                                    <div class="resend-btn">
                                        <img src="/assets/icons/resend.svg" alt="Resend Invite Icon" />
                                    </div>
                                    <div class="state state--pending">Pending</div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <!-- Modal Right Content -->
            <div class="right">
                <div>
                    <div class="field__label">Email Preview</div>
                </div>
                <div class="email-preview">
                    <h3 class="subject">Let’s Coordinate Summer Plans - Join Me on Summer Sanity!</h3>
                    <div class="description">
                        <p>Hello,</p>
                        <p>
                            I just joined this awesome parenting site called <span class="bold">Summer Sanity</span> to help plan my kid's summer schedule, and I think
                            you'll love it too!
                        </p>
                        <p>It's completely free and makes it easy for parents like us to organize summer schedules and share plans with friends.</p>
                        <p>
                            Here’s the best part: if we connect our calendars, we can swap ideas for camps and activities and make sure the kids get plenty of time together
                            this summer—it’s a win-win!
                        </p>
                        <p class="bold">Take a look at how easy it is to use:</p>
                        <img src="/assets/calendar.png" alt="Summer Calendar" />
                        <p class="bold">Click below to join me and start planning:</p>
                        <button class="btn btn--sm">Join Summer Sanity!</button>
                        <div class="email-footer">
                            <p>Can't wait to see what we come up with!</p>
                            <p class="bold">{{ Auth::guard('guardian')->user()->first_name }} {{ Auth::guard('guardian')->user()->last_name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const invitationLink = document.getElementById("invitation-link");
    const invitationModalOverlay = document.getElementById("invitation-modal-overlay");
    const modalCloseBtn = document.querySelector("#invitation-modal-overlay .close-btn");

    const inviteEmailForm = document.getElementById("invite-email-form");

    const hideModal = (overlayEl) => {
        overlayEl.classList.add("hide");
    };

    const showModal = (overlayEl) => {
        overlayEl.classList.remove("hide");
    };

    invitationLink.addEventListener("click", () => {
        showModal(invitationModalOverlay);
    });

    modalCloseBtn?.addEventListener("click", () => {
        hideModal(invitationModalOverlay);
    });

    invitationModalOverlay?.addEventListener("click", (e) => {
        const targetEl = e.target;

        if (!targetEl.classList.contains("modal-overlay")) return;

        hideModal(invitationModalOverlay);
    });

    document.onkeyup = (e) => {
        if (e.key !== "Escape" && !invitationModalOverlay?.classList.contains("hide")) return;

        hideModal(invitationModalOverlay);
    };

    /*
        Edit Plan Modal
    */
    flatpickr("#date-picker", {
        // defaultDate: new Date("2025-04-15"),
        dateFormat: "F j, Y",
    });
</script>