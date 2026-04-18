@extends('vender::layouts.master')

@section('header')
<div class="content-header bg-white shadow-sm mb-4">
  <div class="container-fluid" style="border-bottom: 3px solid #949494;">
    <div class="row px-md-4 py-3 align-items-center">
      <div class="col-12 bg-white">
        <h3 class="h3 font-weight-bold mb-2">Getting Started</h3>
        <div class="breadcrumb-wrapper">
          <ol class="breadcrumb mb-0 bg-transparent p-0">
            <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-muted">Overview</a></li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('css_custom')
<style>
/* --- PROFESSIONAL ACCORDION STYLES --- */
.custom-accordion-item {
  margin-bottom: 15px;
}

.custom-accordion-header {
  display: flex;
  align-items: center;
  min-height: 60px;
  line-height: 1.4;
  border: 2px solid black;
  border-radius: 7px;
  padding: 1.2rem 1rem;
  padding-right: 60px !important;
  /* Forces text to stay away from the dropdown arrow */
  color: black !important;
  background-color: white;
  cursor: pointer;
  position: relative;
  font-weight: 500;
  font-size: 1.15rem;
  transition: all 0.2s ease-in-out;
  text-decoration: none;
}

.custom-accordion-header:hover {
  text-decoration: none;
  background-color: #fcfcfc;
}

/* When the accordion is open, merge it with the content box */
.custom-accordion-header.active {
  border-bottom: none;
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
  padding-bottom: 1.2rem;
}

/* The Feather Icon Toggle */
.custom-accordion-header:before {
  content: "\e843";
  /* Feather icon chevron */
  font-family: 'feather';
  position: absolute;
  top: 50%;
  right: 20px;
  transform: translateY(-50%) rotate(270deg);
  transition: transform 0.3s ease;
  font-size: 22px;
}

.custom-accordion-header.active:before {
  transform: translateY(-50%) rotate(90deg);
}

.custom-collapse-content {
  display: none;
  padding: 20px;
  border-radius: 0 0 7px 7px;
  background: #fcfcfc;
  border: 2px solid black;
  border-top: 1px solid #e0e0e0;
  color: #333;
  line-height: 1.6;
}

.custom-collapse-content h2,
.custom-collapse-content h3,
.custom-collapse-content h4 {
  color: black;
  font-weight: 600;
  margin-top: 1.5rem;
  margin-bottom: 0.75rem;
}

.custom-collapse-content h2 {
  font-size: 1.4rem;
}

.custom-collapse-content h3 {
  font-size: 1.2rem;
}

.custom-collapse-content h4 {
  font-size: 1.1rem;
}

.custom-collapse-content ul,
.custom-collapse-content ol {
  margin-bottom: 1rem;
  padding-left: 1.5rem;
}

.custom-collapse-content li {
  margin-bottom: 0.5rem;
}

/* --- PROFESSIONAL SIDEBAR OVERVIEW STYLES --- */
.sidebar-overview {
  border-radius: 7px;
  border: 2px solid black;
  background-color: #fcfdfe;
  /* Very subtle blue/grey tint */
  padding-bottom: 20px;
  margin-bottom: 20px;
  box-shadow: 4px 4px 0px rgba(0, 0, 0, 0.04);
  /* Soft modern shadow */
}

.sidebar-header {
  border-radius: 5px 5px 0 0;
  padding: 15px 20px;
  font-weight: 600;
  font-size: 1.2rem;
  color: black;
  border-bottom: 1px solid #eaeaea;
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 15px;
  background-color: white;
  /* Keeps the header distinctly separate */
}

.sidebar-content {
  padding: 0 20px;
}

.overview-lead {
  font-size: 1.15rem;
  font-weight: 600;
  color: #111;
  margin-bottom: 0.75rem;
}

.sidebar-content p:not(.overview-lead) {
  line-height: 1.6;
  color: #444;
  margin-bottom: 1rem;
  max-width: 750px;
  /* Constrains line length so it doesn't stretch too far, improving readability */
}

/* --- RESPONSIVE ENHANCEMENTS --- */
.custom-collapse-content table {
  width: 100%;
  display: block;
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
  border-collapse: collapse;
  margin-top: 1rem;
}

.custom-collapse-content table th,
.custom-collapse-content table td {
  border: 1px solid #ccc;
  padding: 10px;
}

.custom-collapse-content table th {
  background-color: #f1f1f1;
}

img {
  max-width: 100%;
  height: auto;
}

/* Ensure the sidebar box behaves perfectly on tablets (768px - 1199px) */
@media (min-width: 768px) and (max-width: 1199px) {
  .sidebar-overview {
    max-width: 100%;
    margin-bottom: 30px;
  }
}

/* Mobile View Adjustments (Screens smaller than 768px) */
@media (max-width: 767px) {
  .content-header .row {
    padding-left: 15px !important;
    padding-right: 15px !important;
  }

  .custom-accordion-header {
    font-size: 1.05rem;
  }
}
</style>
@endsection

@section('content')
<div class="container-fluid px-md-4">
  <div class="row">

    <div class="col-xl-3 col-lg-12 mb-4">
      <div class="sidebar-overview h-100">
        <div class="sidebar-header">
          <img src="/task.png" style="width: 30px;" alt="Task">
          <span>Overview</span>
        </div>
        <div class="sidebar-content">
          <p class="overview-lead">Almost there!</p>
          <p>Welcome to your Business Manager Portal. We just need a few details to get your business up and running.
          </p>
          <p>Verify your information, set up your services, staff, bookings, and invoices — once that’s done, your
            mobile app will be ready to go!</p>
          <p>Follow the checklist to complete your Business Setup. Once all steps are done, your business will be
            activated.</p>
        </div>
      </div>
    </div>

    <div class="col-xl-9 col-lg-12">
      <div class="accordion-wrapper pb-5">

        <div class="custom-accordion-item">
          <a href="javascript:void(0);" class="custom-accordion-header" onclick="toggleCollapse(this)"
            data-target="#collapseContent14">
            Add a Site
          </a>
          <div id="collapseContent14" class="custom-collapse-content">
            <p><strong>A Site</strong> is the physical location where your business operates. Every <strong>Trade
                Unit</strong> must be linked to a Site.</p>
            <ul>
              <li>By default, your <strong>registered business address</strong> is automatically added as your first
                Site.</li>
              <li>If your Trade Unit operates from this same address, <strong>you do not need to add another
                  Site.</strong></li>
              <li>Only if a Trade Unit operates from a <strong>different address</strong> (for example, another branch,
                workshop, or office) will you need to <strong>add that Site first.</strong></li>
              <li>Once the Site is created and verified, you can then link a Trade Unit to it.</li>
            </ul>
            <p>This setup ensures each <strong>Trade Unit</strong> is tied to the correct location, making it easier to
              manage businesses with multiple premises.</p>

            <h4>How to Add a New Site</h4>
            <p>Please follow these steps <strong>only if you need to add a Site:</strong></p>
            <ol>
              <li>Go to <strong>Business &gt; Sites</strong> in the main menu.</li>
              <li>Click <strong>Add</strong>.</li>
              <li>Provide the <strong>address details</strong> for this location.</li>
              <li>Upload all <strong>required proof documents</strong> (e.g., utility bill, lease agreement, or business
                rates document).</li>
              <li>Save your changes.</li>
            </ol>
            <p><strong>Tip:</strong> You can keep track of verification status by going to the
              <strong>Verifications</strong> section. All required proof must be provided when adding a Site, but the
              Verifications section lets you monitor progress and updates in one place.
            </p>
            <p>Once the Site is <strong>verified</strong>, it is ready to use, and you can proceed to add a Trade Unit
              and link it to this Site.</p>
          </div>
        </div>

        <div class="custom-accordion-item">
          <a href="javascript:void(0);" class="custom-accordion-header" onclick="toggleCollapse(this)"
            data-target="#bank_payout">
            Add a Bank Account for Payouts
          </a>
          <div id="bank_payout" class="custom-collapse-content">
            <h2>Payout Account</h2>
            <p>Your <strong>Payout Account</strong> is the bank account where <strong>refunds and payouts from the
                platform</strong> will be sent.</p>
            <p>To set up a Payout Account, first, you need to add a bank account and have it verified.</p>

            <h3>Adding a Bank Account for Payouts</h3>
            <ul>
              <li>The bank account must belong to your <strong>registered business</strong> or be in the <strong>trading
                  name</strong> associated with your business.</li>
              <li>You will be asked to upload supporting documents (such as a recent bank statement).</li>
              <li>You can add <strong>multiple bank accounts</strong>. Each account can be given a
                <strong>label</strong> (for example, “Main Account” or “Savings Account”) to help you identify them.
                There is no default account — you choose which one to use when setting up payouts.
              </li>
            </ul>

            <h4>How to Add a Bank Account</h4>
            <p>Please follow these steps to add a new account:</p>
            <ol>
              <li>Go to <strong>Business > Bank Accounts</strong> in the main menu.</li>
              <li>Click <strong>Add</strong>.</li>
              <li>Enter your account holder name, sort code, and account number.</li>
              <li>Add a label to help you recognise this account.</li>
              <li>Upload any <strong>required supporting documentation</strong> to verify the account (e.g., bank
                statement or account confirmation letter).</li>
              <li>Save your changes.</li>
            </ol>
            <p>Once saved, you can <strong>keep track of verification status</strong> by going to the
              <strong>Verifications</strong> section, which allows you to monitor all pending and completed
              verifications in one place. Verification is <strong>required</strong> before the account can be used as a
              payout account. Once verified, go to <strong>Billings &amp; Payments > Payout Account</strong> to link the
              bank account for refunds and payouts.
            </p>
          </div>
        </div>

        <div class="custom-accordion-item">
          <a href="javascript:void(0);" class="custom-accordion-header" onclick="toggleCollapse(this)"
            data-target="#upload_proof">
            Upload Proof Documentation for Verification
          </a>
          <div id="upload_proof" class="custom-collapse-content">
            <p>Certain actions in the platform require <strong>verification</strong>. This includes <strong>adding a
                Site, adding a Bank Account for Payouts, and verifying your business</strong>. Uploading proof documents
              is <strong>mandatory</strong> to make your account <strong>LIVE</strong>.</p>
            <ul>
              <li><strong>Business Verification:</strong> Documents to confirm your business registration and identity,
                such as a <strong>certificate of incorporation, business registration certificate, or official
                  government-issued documents</strong>.</li>
              <li><strong>Sites:</strong> Documents such as a <strong>utility bill, lease agreement, or business rates
                  notice</strong> to confirm the address.</li>
              <li><strong>Bank Accounts:</strong> A <strong>recent bank statement</strong> or other document showing the
                account belongs to your business.</li>
              <li>The system will <strong>automatically list all required documents based</strong> on the information
                you provided during registration, and when adding <strong>Sites</strong> or <strong>Bank
                  Accounts</strong>.</li>
              <li>Each document you upload will be <strong>reviewed by the platform</strong> to ensure it meets
                verification requirements.</li>
            </ul>

            <h3>How to Upload Proof Documents</h3>
            <ol>
              <li>Go to <strong>Business > Verification Documents</strong> in the main menu.</li>
              <li>You will see a list of <strong>all required documents</strong> according to your registration and
                added Sites/Bank Accounts.</li>
              <li>Click <strong>Upload Document</strong> next to each required item.</li>
              <li>Choose the relevant file from your device.</li>
              <li>Save your changes.</li>
            </ol>
            <p>✅ Once uploaded, the documents will be <strong>reviewed</strong>.</p>
            <p>✅ After all verifications are <strong>approved</strong>, your business, Sites, and Bank Accounts will be
              ready to use, and your account will be <strong>LIVE</strong>.</p>
          </div>
        </div>

        <div class="custom-accordion-item">
          <a href="javascript:void(0);" class="custom-accordion-header" onclick="toggleCollapse(this)"
            data-target="#pay_out">
            Add a Payout Account
          </a>
          <div id="pay_out" class="custom-collapse-content">
            <h3>Adding a Payout Account</h3>
            <p>Your <strong>Payout Account</strong> is the bank account where <strong>refunds and payouts from the
                platform</strong> will be sent.</p>
            <p><strong>Precondition:</strong> Only a <strong>verified bank account</strong> can be linked as a Payout
              Account.</p>
            <p>Once your bank account is verified, you can link it as your Payout Account.</p>

            <h3>How to Link a Verified Bank Account as Payout Account</h3>
            <ol>
              <li>Go to <strong>Billing &amp; Payments > Payout Account</strong> in the main menu.</li>
              <li>Click <strong>Edit</strong>.</li>
              <li>Select one of your <strong>verified bank accounts</strong> from the list.</li>
              <li>Save your changes.</li>
            </ol>
            <p>✅ Your selected bank account is now set as your <strong>Payout Account</strong> and will be used for all
              platform payouts and refunds.</p>
            <p>💡 <strong>Tip:</strong> If your bank account is not yet verified, it <strong>will not appear</strong> in
              the list of accounts to link. Make sure to complete bank account verification first.</p>
          </div>
        </div>

        <div class="custom-accordion-item">
          <a href="javascript:void(0);" class="custom-accordion-header" onclick="toggleCollapse(this)"
            data-target="#trading_name">
            Add Trading Names
          </a>
          <div id="trading_name" class="custom-collapse-content">
            <h3>Add Trading Names</h3>
            <p>A <strong>Trading Name</strong> is an alternative name your business operates under, different from your
              registered business name. Adding trading names helps customers and partners recognize your business if it
              is known by multiple names.</p>
            <ul>
              <li>You can have <strong>multiple trading names</strong> for your business.</li>
              <li>Each trading name is linked to your <strong>registered business</strong> and appears in the system for
                identification and reporting purposes.</li>
              <li>Trading names <strong>appear in the Marketplace</strong> and <strong>on invoices</strong>, so
                customers will see the name you choose here.</li>
              <li>Adding a trading name does <strong>not require</strong> a separate address or bank account — it is
                just a name associated with your business.</li>
              <li><strong>Important:</strong> When adding a Trade Unit, you will need to <strong>link a trading
                  name</strong> if your business has any.</li>
            </ul>

            <h3>How to Add a Trading Name</h3>
            <ol>
              <li>Go to <strong>Business > Trading Names</strong> in the main menu.</li>
              <li>Click <strong>Add Trading Name</strong>.</li>
              <li>Enter the <strong>Trading Name</strong> you want to add.</li>
              <li>Save your changes.</li>
            </ol>
            <p>✅ Your trading name is now linked to your business and will appear in the Marketplace, on invoices, and
              in other relevant sections of the platform.</p>
            <p>✅ It will also be available to <strong>link when adding Trade Units</strong>, if your business has
              multiple trading names.</p>
          </div>
        </div>

        <div class="custom-accordion-item">
          <a href="javascript:void(0);" class="custom-accordion-header" onclick="toggleCollapse(this)"
            data-target="#trade_unit">
            Add a Trade Unit
          </a>
          <div id="trade_unit" class="custom-collapse-content">
            <h3>Adding a Trade Unit</h3>
            <p>The <strong>Trade Unit</strong> is the core operational and customer-facing entity of your business in
              the platform. It represents a specific branch, workshop, or service outlet. All other elements—such as
              Sites, Trading Names, and email addresses—are linked to it. Trade Units help manage operations, reporting,
              and Marketplace presence, as this is what your customers interact with.</p>
            <ul>
              <li>A Trade Unit <strong>must be linked to a Site</strong>.
                <ul>
                  <li>If the Trade Unit operates at your registered business address, the default Site can be used.</li>
                  <li>If it operates at a different address, you must add that Site first.</li>
                </ul>
              </li>
              <li>If your business has one or more Trading Names, you will need to link the appropriate <strong>Trading
                  Name</strong> to the Trade Unit.</li>
              <li>Trade Units appear in the Marketplace and are used for operational and reporting purposes.</li>
            </ul>

            <h3>How to Add a Trade Unit</h3>
            <ol>
              <li>Go to <strong>Products > Service Provider > Trade Units</strong> in the main menu.</li>
              <li>Click <strong>Add</strong>.</li>
              <li>Enter the relevant details for the Trade Unit (such as name, Site, and Trading Name if applicable).
              </li>
              <li>Save your changes.</li>
            </ol>
            <p>✅ The Trade Unit is now the <strong>core entity</strong> your customers will interact with. It will
              appear in the system for operations, reporting, and Marketplace listings.</p>
          </div>
        </div>

        <div class="custom-accordion-item">
          <a href="javascript:void(0);" class="custom-accordion-header" onclick="toggleCollapse(this)"
            data-target="#book_time">
            Set Booking Times
          </a>
          <div id="book_time" class="custom-collapse-content">
            <p><strong>Booking Times</strong> configure the diary for each Trade Unit in the Service Provider app. They
              define the time slots available for scheduling work, helping you structure and manage your day
              efficiently.</p>
            <p>When setting up Booking Times, you will define:</p>
            <ul>
              <li><strong>Booking Start Time</strong> – the earliest slot in the diary.</li>
              <li><strong>Booking Time Intervals</strong> – the spacing of diary slots (e.g., every 15, 30, or 60
                minutes).</li>
              <li><strong>Booking End Time</strong> – the last slot available in the diary.</li>
            </ul>

            <h3>How to Set Booking Times</h3>
            <ol>
              <li>Go to <strong>Products > Service Provider > Trade Units</strong> in the main menu.</li>
              <li>Select the <strong>Trade Unit</strong> you want to configure.</li>
              <li>Select <strong>App settings</strong>.</li>
              <li>Select <strong>Booking Times</strong> option.</li>
              <li>Click <strong>Edit</strong>.</li>
              <li>Enter the <strong>Start Time, Intervals, and End Time</strong> that reflect your working hours.</li>
              <li>Save your changes.</li>
            </ol>
            <p>✅ The diary for that Trade Unit is now structured around your chosen <strong>Booking Times</strong>.</p>
            <p>✅ All scheduling within the Service Provider app will follow these defined slots.</p>
          </div>
        </div>

        <div class="custom-accordion-item">
          <a href="javascript:void(0);" class="custom-accordion-header" onclick="toggleCollapse(this)"
            data-target="#workstream">
            Add Workstreams
          </a>
          <div id="workstream" class="custom-collapse-content">
            <p><strong>Workstreams</strong> are essential for organising jobs within a Trade Unit. They represent the
              categories or channels of work that can be booked into the diary.</p>
            <ul>
              <li>At least <strong>one Workstream must be created</strong> for each Trade Unit, since a Workstream must
                be selected when adding a booking.</li>
              <li>Workstreams can be set up in a way that suits your business — for example:
                <ul>
                  <li>By <strong>service type</strong> (MOT, Repairs, Servicing, Diagnostics).</li>
                  <li>By <strong>technician</strong> (e.g., naming a Workstream after a mechanic).</li>
                </ul>
              </li>
              <li>This flexibility allows garages to structure their diary and job management in the way that works best
                for them.</li>
            </ul>

            <h3>How to Add a Workstream</h3>
            <ol>
              <li>Go to <strong>Products > Service Provider > Trade Units</strong> in the main menu.</li>
              <li>Select the <strong>Trade Unit</strong> you want to configure.</li>
              <li>Select <strong>App Settings</strong>.</li>
              <li>Select <strong>Workstreams</strong>.</li>
              <li>Click <strong>Add</strong> and enter the <strong>name and details</strong>.</li>
              <li>Save your changes.</li>
            </ol>
            <p>✅ The new Workstream will now be available in the diary for scheduling bookings.</p>
            <p>✅ Multiple Workstreams can be created per Trade Unit, giving you full flexibility in how you organise
              work.</p>

            <h3>Tip: Naming Workstreams</h3>
            <p>When naming Workstreams, keep the names short and easy to recognise in the diary. For example:</p>
            <ul>
              <li>Use <strong>service types</strong> (MOT, Servicing, Repairs) if you want to categorise jobs by type.
              </li>
              <li>Use <strong>technician names</strong> if you want to allocate jobs directly to staff.</li>
              <li>If you have <strong>multiple technicians performing the same service</strong>, create separate
                Workstreams for each. Examples:
                <ul>
                  <li>“MOT – Technician 1 Name” and “MOT – Technician 2 Name”</li>
                  <li>“Repairs – Technician 1 Name” and “Repairs – Technician 2 Name”</li>
                </ul>
              </li>
            </ul>
            <p>Clear naming makes scheduling and managing bookings simpler for everyone in your team.</p>
          </div>
        </div>

        <div class="custom-accordion-item">
          <a href="javascript:void(0);" class="custom-accordion-header" onclick="toggleCollapse(this)"
            data-target="#email_address">
            Add Email Address
          </a>
          <div id="email_address" class="custom-collapse-content">
            <p>Email addresses are used purely for <strong>linking purposes</strong> in the platform. They are currently
              required for <strong>Invoice Document Settings</strong> to ensure invoices display correct contact details
              for remittance.</p>
            <ul>
              <li><strong>Garage Email Address</strong> – The primary email for the garage, entered in the Garage
                Details section (name, address, etc).</li>
              <li><strong>Remittance Email</strong> – Used if the garage accepts payments by bank transfer, so customers
                know where to send remittance information.</li>
              <li><strong>Optional</strong> – If you do not want your email address on invoice documents for contact
                purposes, or do not need a remittance email address, you can <strong>skip this section</strong>.</li>
            </ul>

            <h3>How to Add an an Email Address</h3>
            <ol>
              <li>Go to <strong>Business > Email Addresses</strong> in the main menu.</li>
              <li>Click <strong>Add</strong>.</li>
              <li>Enter the <strong>email address</strong> you want to link.</li>
              <li>Save your changes.</li>
            </ol>
            <p>✅ Once added, the email address can be linked in <strong>Invoice Document Settings</strong>.</p>
            <p>✅ You can add multiple email addresses as needed for different purposes, such as remittance or other
              invoice contacts.</p>

            <h3>Tip: Linking Email Addresses for Invoices</h3>
            <ul>
              <li>If you have <strong>one email address</strong> for both the garage contact and remittance, simply add
                <strong>one email address</strong> and link it from the relevant invoice settings.
              </li>
              <li>If you have <strong>two separate email addresses</strong> (one for general garage contact, one for
                remittance), add <strong>both email addresses</strong> and link each to its corresponding invoice
                setting.</li>
            </ul>
            <p>This ensures invoices always display the correct email address for each purpose.</p>
          </div>
        </div>

        <div class="custom-accordion-item">
          <a href="javascript:void(0);" class="custom-accordion-header" onclick="toggleCollapse(this)"
            data-target="#invoice_doc">
            Set Invoice Document
          </a>
          <div id="invoice_doc" class="custom-collapse-content">
            <p><strong>Invoice Document Settings</strong> allow you to configure how invoices appear and what business
              and contact information is displayed. Each invoice is linked to a <strong>specific Trade Unit</strong>, so
              the correct details are shown for that location.</p>
            <p><strong>Note:</strong> Configuring Invoice Document Settings is <strong>mandatory</strong> for the
              Service Provider app. You cannot proceed without completing this step.</p>
            <ul>
              <li><strong>Business Name Format</strong> – How your business name will appear on invoices.</li>
              <li><strong>Site Address</strong> – Used for contact purposes on the invoice.</li>
              <li><strong>Other Contact Details</strong> – Includes phone number, email address, and any other relevant
                contact information.</li>
              <li><strong>Optional Bank Transfer Details</strong> – If the garage accepts bank transfers, you can link a
                verified bank account, so remittance details appear on the invoice.</li>
            </ul>

            <h3>How to Configure Invoice Document Settings</h3>
            <ol>
              <li>Go to <strong>Products > Service Provider > Trade Units</strong> in the main menu.</li>
              <li>Select the <strong>Trade Unit</strong> you want to configure.</li>
              <li>Open <strong>App settings</strong>.</li>
              <li>Select <strong>Invoice Document Settings</strong>.</li>
              <li>Configure the <strong>Business Name Format</strong> as you want it to appear on invoices.</li>
              <li>Enter the <strong>Site Address</strong> for contact purposes.</li>
              <li>Add <strong>other contact details</strong>, including a <strong>Contact Email Address</strong> if
                desired.</li>
              <li>If accepting bank transfers, link the <strong>verified bank account</strong> to display remittance
                information.</li>
              <li>Save your changes.</li>
            </ol>
            <p>✅ Invoices for this Trade Unit will now display the correct business, site, and contact information.</p>
            <p>✅ Any linked verified bank account will provide customers with the correct remittance details.</p>
            <p>✅ Settings can be updated at any time to reflect changes in business or contact information.</p>

            <h3>Tip: Linking Bank and Email Details</h3>
            <ul>
              <li>Ensure that the <strong>contact email</strong> is active and monitored.</li>
              <li>Only link <strong>verified bank accounts</strong> for remittance purposes.</li>
              <li>If using one email address for both contact and remittance, link it in both fields; otherwise, link
                separate addresses appropriately.</li>
            </ul>
          </div>
        </div>

        <div class="custom-accordion-item">
          <a href="javascript:void(0);" class="custom-accordion-header" onclick="toggleCollapse(this)"
            data-target="#add_user">
            Add User
          </a>
          <div id="add_user" class="custom-collapse-content">
            <p>All user management is handled from the <strong>Directory</strong>, a <strong>standalone main menu
                section</strong>. This is where you create, update, link, and control access for all users across your
              platform.</p>
            <ul>
              <li>When adding a user, you <strong>first assign them to one or more apps</strong> (e.g., Business Manager
                app, Service Provider app).</li>
              <li>Roles and permissions are <strong>app-specific</strong>, meaning a user may have different access
                levels in each product.</li>
              <li><strong>Default roles and permissions</strong> are pre-configured to cover the most common scenarios
                and <strong>cannot be edited</strong>.</li>
              <li><strong>Custom roles and permissions</strong> can be added for advanced users who require tailored
                access.</li>
              <li><strong>Linking a user to Trade Units</strong> is <strong>specific to the Service Provider
                  app</strong>, so only Service Provider users need to be associated with Trade Units.</li>
              <li>Multiple users can be added across apps and Trade Units as needed.</li>
              <li>From the Directory, you can <strong>edit, deactivate, or remove users</strong> at any time.</li>
            </ul>

            <h3>How to Add a User</h3>
            <ol>
              <li>Go to <strong>Directory > Users</strong> in the main menu.</li>
              <li>Click <strong>Add</strong>.</li>
              <li>Enter the <strong>relevant details</strong> (name, email, etc.).</li>
              <li><strong>Assign the user to one or more apps.</strong></li>
              <li>For each app, assign <strong>default or custom roles/permissions</strong> according to their
                responsibilities.</li>
              <li>If assigning the user to the <strong>Service Provider app</strong>, link them to <strong>one or more
                  Trade Units</strong> as needed.</li>
              <li>Save your changes.</li>
            </ol>
            <p>✅ The user will now have access to the selected apps according to the roles and permissions assigned.</p>
            <p>✅ Users can be updated, deactivated, or removed entirely from this section.</p>

            <h3>Tip: Managing Users Across Apps and Trade Units</h3>
            <ul>
              <li>Default roles cover most common scenarios and <strong>cannot be edited</strong>.</li>
              <li>Only create <strong>custom roles</strong> if advanced or specific access is required.</li>
              <li>Only give <strong>Admin access</strong> in any app to trusted personnel.</li>
              <li>Assign <strong>Manager or Staff roles</strong> according to what the user needs to do in each app.
              </li>
              <li>Ensure each user has a <strong>unique and monitored email address</strong> for login and
                notifications.</li>
              <li>Linking users to multiple Trade Units applies <strong>only for Service Provider users</strong>, giving
                flexibility for staff covering several locations.</li>
              <li>All user management—adding, updating, linking, and removing—is <strong>fully controlled from the
                  Directory > Users section</strong>.</li>
            </ul>

            <h3>Example Scenario: Service Provider App with One Trade Unit</h3>
            <p>Suppose a garage has <strong>one Trade Unit</strong>. Using the <strong>pre-configured default
                roles</strong>, the following users are added:</p>

            <div class="table-responsive">
              <table class="table table-bordered table-striped mt-3">
                <thead class="thead-light">
                  <tr>
                    <th>User</th>
                    <th>App Access</th>
                    <th>Role (Default)</th>
                    <th>Trade Unit Access</th>
                    <th>Permissions Summary</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Owner</td>
                    <td>Service Provider App</td>
                    <td>Admin</td>
                    <td>Linked to Trade Unit 1</td>
                    <td>Full access to all settings, workstreams, diary, invoices.</td>
                  </tr>
                  <tr>
                    <td>Manager</td>
                    <td>Service Provider App</td>
                    <td>Manager</td>
                    <td>Linked to Trade Unit 1</td>
                    <td>Can manage bookings, workstreams, and the diary; cannot change app-level settings.</td>
                  </tr>
                  <tr>
                    <td>Technician</td>
                    <td>Service Provider App</td>
                    <td>Staff</td>
                    <td>Linked to Trade Unit 1</td>
                    <td>Can view and update jobs in the diary; mark work as completed.</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <p>Each user is linked to the <strong>same Trade Unit</strong>, ensuring they can access relevant jobs and
              bookings.</p>
            <p>✅ <strong>Default roles</strong> cover the most common operational needs and <strong>cannot be
                edited</strong>.</p>
            <p>✅ Roles define <strong>who can configure the system vs. who can operate it day-to-day</strong>,
              maintaining security and clarity.</p>

            <h3>Optional:</h3>
            <p>For advanced users with specialized responsibilities, <strong>custom roles</strong> can be created with
              tailored permissions, but this is only recommended for experienced administrators.</p>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts_lib')
<script>
function toggleCollapse(element) {
  const targetId = element.getAttribute('data-target');
  const content = document.querySelector(targetId);

  // Check if the clicked item is already open
  const isVisible = content.style.display === 'block';

  // Close all content areas first
  document.querySelectorAll('.custom-collapse-content').forEach(c => {
    c.style.display = 'none';
  });

  // Remove active class from all headers
  document.querySelectorAll('.custom-accordion-header').forEach(h => {
    h.classList.remove('active');
  });

  // If it wasn't visible before, open it and set to active
  if (!isVisible) {
    content.style.display = 'block';
    element.classList.add('active');
  }
}
</script>
@endsection