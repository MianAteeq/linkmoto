@extends('frontend::new-layouts.master')

@section('css')
    <style>
        /* Heading */
        .heading {
            font-weight: 800;
            font-size: 18px;
            margin: 0 0 14px 0;
            color: black;
        }

        /* Intro paragraph */
        .intro {
            margin: 0 0 22px 0;
            font-size: 15px;
            line-height: 1.5;
            color: black;
        }

        p {
            color: black;
        }

        .intro strong {
            font-weight: 700;
        }

        /* Section titles */
        .section {
            margin-bottom: 18px;
        }

        .section-title {
            font-size: 15px;
            font-weight: 700;
            margin: 0 0 8px 0;
            color: black;
        }

        /* Lists */
        .list {
            margin: 0 0 0 18px;
            padding: 0;
            list-style: disc;
            color: var(--black);
            font-size: 15px;
            line-height: 1.6;
            color: black;
        }

        .list li {
            margin: 8px 0;
        }

        /* Emphasis inside list items (bold keywords) */
        .list b,
        .list strong {
            font-weight: 700;
        }

        /* Small misc styling to match screenshot spacing */
        .muted {
            color: var(--muted);
            font-size: 14px;
        }

        /* Responsive adjustments */
        @media (max-width:520px) {
            .container {
                padding: 18px;
            }

            .heading {
                font-size: 18px;
            }

            .section-title {
                font-size: 14px;
            }
        }
    </style>
@endsection
@section('content')
    <div class="content-body">
        <div class="row" style="border-bottom: 3px solid #949494;">
            <div class="col-xl-12 col-12">
                <h3 class="h3">Business registration application</h3>
            </div>

        </div>

        <div class="row" style="margin-top: 10px;">
            <div class="col-md-4">

                <h4 class="h3"
                    style="border-radius: 7px;border: 2px solid black;padding: 10px;font-weight: 600;
            font-size: 17px; ">
                    <img src="/home.png" style="width: 22px;margin-top: -5px;"> Overview</h2>

            </div>

            <div class="col-md-8" style="border: 2px solid black;border-radius: 8px;padding:inherit">
                <div class="link-body" style="padding: 10px">
                    <h1 id="welcome-heading" class="heading">Welcome to LinkMoto!</h1>

                    <p class="intro">
                        You’ve been invited to complete your <strong>full registration</strong> for the LinkMoto closed
                        beta.
                    </p>

                    <section class="section" aria-labelledby="provide-title">
                        <p id="provide-title" class="section-title"><strong>What you’ll provide:</strong></p>

                        <ul class="list" aria-label="What you'll provide list">
                            <li><strong>Business Details:</strong> Business name, address, VAT number (if applicable), and
                                contact information.</li>
                            <li><strong>Main Contact Person:</strong> Name, role, email, and phone number.</li>
                        </ul>
                    </section>

                    <section class="section" aria-labelledby="notes-title">
                        <p id="notes-title" class="section-title"><strong>Key Notes:</strong></p>

                        <ul class="list" aria-label="Key notes list">
                            <li>Participation in the closed beta is <strong> free of charge</strong> — no fees,
                                subscriptions, or commissions at this stage.</li>
                            <li>All information and documents are handled securely and in accordance with our
                                <strong>Privacy Policy</strong>.
                            </li>
                            <li>Completing this step unlocks access to the <strong>Business Manager Portal</strong> and the
                                <strong>Service Provider app</strong> once your account is approved.
                            </li>
                            <li><strong>Required documents</strong> (e.g., proof of identity, business registration,
                                insurance certificates) will be requested <strong>after portal access is granted</strong>.
                            </li>
                        </ul>
                    </section>



                </div>
                <div class="footers">
                    <form action="{{ route('vender.profile.start') }}" method="POST">

                        @csrf

                        <input type="hidden" id="is_save_later" name="is_save_later" value="0">
                        <button type="submit" class="btn btn-dark round btn-min-width mr-1 mb-1" style="float: right;">SAVE
                            AND NEXT</button>
                        <a onclick="saveforlater()"> <button type="button"
                                class="btn btn-dark round btn-min-width mr-1 mb-1" style="float: right;">SAVE AND
                                EXIT</button></a>

                    </form>

                </div>

            </div>

        </div>

    </div>
@endsection

@section('js')
    <script>
        function saveforlater() {
            $('#is_save_later').val(1);
            $("form").submit();
        }
    </script>
@endsection
