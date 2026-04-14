@extends('frontend::layout.app')

@section('css')
<style>
/* Typography and spacing adjustments for mobile readability */
.privacy-content {
  color: #333;
  line-height: 1.6;
}

.privacy-content ul {
  padding-left: 20px;
}

.privacy-content li {
  margin-bottom: 8px;
}

.privacy-content p {
  margin-bottom: 15px;
}

@media (max-width: 768px) {
  .privacy-area.pt-100 {
    padding-top: 50px !important;
    /* Reduce large top gap on mobile */
  }

  .privacy-content h1 {
    font-size: 28px;
  }

  .privacy-content h2 {
    font-size: 22px;
  }

  .privacy-content h3 {
    font-size: 18px;
  }
}
</style>
@endsection

@section('content')
<section class="privacy-area pt-100 pb-5">
  <div class="container px-3 px-md-4">
    <h2>Privacy Policy</h2>

    <div class="privacy-content mt-4">
      <h1 data-start="146" data-end="178"><strong data-start="148" data-end="178">Privacy Policy for Motonos</strong>
      </h1>
      <p data-start="180" data-end="216"><strong data-start="180" data-end="199">Effective Date:</strong> January 29,
        2026</p>
      <p data-start="218" data-end="432">At <strong data-start="221" data-end="232">Motonos</strong>, accessible from
        <strong data-start="250" data-end="274"><a class="decorated-link" href="https://motonos.com/" target="_new"
            rel="noopener" data-start="252" data-end="272">https://motonos.com/</a></strong>, we take your privacy
        seriously. This Privacy Policy outlines the types of information we collect, how we use it, and your rights
        regarding that information.
      </p>

      <hr data-start="434" data-end="437" class="my-4" />

      <h2 data-start="439" data-end="471"><strong data-start="442" data-end="471">1. Information We Collect</strong>
      </h2>

      <h3 data-start="473" data-end="494" class="mt-3"><strong data-start="477" data-end="494">Personal Data</strong>
      </h3>
      <p data-start="496" data-end="609">We may collect personally identifiable information that you voluntarily provide
        when using our services, such as:</p>
      <ul data-start="611" data-end="696">
        <li data-start="611" data-end="617">Name</li>
        <li data-start="618" data-end="633">Email address</li>
        <li data-start="634" data-end="648">Phone number</li>
        <li data-start="649" data-end="658">Address</li>
        <li data-start="659" data-end="696">Payment information (if applicable)</li>
      </ul>

      <h3 data-start="698" data-end="716" class="mt-3"><strong data-start="702" data-end="716">Usage Data</strong></h3>
      <p data-start="718" data-end="814">We automatically collect information about how you access and interact with our
        site, including:</p>
      <ul data-start="816" data-end="913">
        <li data-start="816" data-end="828">IP address</li>
        <li data-start="829" data-end="855">Browser type and version</li>
        <li data-start="856" data-end="871">Pages visited</li>
        <li data-start="872" data-end="896">Time and date of visit</li>
        <li data-start="897" data-end="913">Referring site</li>
      </ul>

      <hr data-start="915" data-end="918" class="my-4" />

      <h2 data-start="920" data-end="957"><strong data-start="923" data-end="957">2. How We Use Your
          Information</strong></h2>
      <p data-start="959" data-end="991">We use collected information to:</p>
      <ul data-start="993" data-end="1208">
        <li data-start="993" data-end="1038">Provide, maintain, and improve our services</li>
        <li data-start="1039" data-end="1087">Respond to your inquiries and support requests</li>
        <li data-start="1088" data-end="1117">Personalize your experience</li>
        <li data-start="1118" data-end="1140">Process transactions</li>
        <li data-start="1141" data-end="1208">Send updates, newsletters, and promotional content (if permitted)</li>
      </ul>

      <hr data-start="1210" data-end="1213" class="my-4" />

      <h2 data-start="1215" data-end="1258"><strong data-start="1218" data-end="1258">3. Cookies and Tracking
          Technologies</strong></h2>
      <p data-start="1260" data-end="1312">We use cookies and similar tracking technologies to:</p>
      <ul data-start="1314" data-end="1404">
        <li data-start="1314" data-end="1352">Understand and save your preferences</li>
        <li data-start="1353" data-end="1377">Analyze usage patterns</li>
        <li data-start="1378" data-end="1404">Improve site performance</li>
      </ul>
      <p data-start="1406" data-end="1470">You can manage cookie preferences through your browser settings.</p>

      <hr data-start="1472" data-end="1475" class="my-4" />

      <h2 data-start="1477" data-end="1516"><strong data-start="1480" data-end="1516">4. How We Share Your
          Information</strong></h2>
      <p data-start="1518" data-end="1553">We may share your information with:</p>
      <ul data-start="1555" data-end="1679">
        <li data-start="1555" data-end="1606">Service providers who help us operate the website</li>
        <li data-start="1607" data-end="1645">Legal authorities if required by law</li>
        <li data-start="1646" data-end="1679">Third parties with your consent</li>
      </ul>
      <p data-start="1681" data-end="1745">We do <strong data-start="1687" data-end="1699">not sell</strong> your
        personal information to outside parties.</p>

      <hr data-start="1747" data-end="1750" class="my-4" />

      <h2 data-start="1752" data-end="1775"><strong data-start="1755" data-end="1775">5. Data Security</strong></h2>
      <p data-start="1777" data-end="1994">We implement industry-standard security measures to protect your personal
        data. However, no method of transmission over the internet is completely secure. You acknowledge that you
        provide information at your own risk.</p>

      <hr data-start="1996" data-end="1999" class="my-4" />

      <h2 data-start="2001" data-end="2032"><strong data-start="2004" data-end="2032">6. Your Choices &amp;
          Rights</strong></h2>
      <p data-start="2034" data-end="2088">Depending on your location, you may have the right to:</p>
      <ul data-start="2090" data-end="2216">
        <li data-start="2090" data-end="2124">Access your personal information</li>
        <li data-start="2125" data-end="2147">Correct inaccuracies</li>
        <li data-start="2148" data-end="2179">Request deletion of your data</li>
        <li data-start="2180" data-end="2216">Opt-out of marketing communication</li>
      </ul>
      <p data-start="2218" data-end="2318" class="text-break">To exercise these rights, contact us at: <strong
          data-start="2259" data-end="2284">[<a class="decorated-link cursor-pointer"
            rel="noopener">contact@motonos.com</a>]</strong> (replace with your contact email)</p>

      <hr data-start="2320" data-end="2323" class="my-4" />

      <h2 data-start="2325" data-end="2353"><strong data-start="2328" data-end="2353">7. Children&rsquo;s
          Privacy</strong></h2>
      <p data-start="2355" data-end="2570">Our services are <strong data-start="2372" data-end="2409">not directed to
          children under 13</strong>. We do not knowingly collect personal information from children under 13. If you
        believe we have done so, please contact us and we will delete that information.</p>

      <hr data-start="2572" data-end="2575" class="my-4" />

      <h2 data-start="2577" data-end="2609"><strong data-start="2580" data-end="2609">8. Changes to This Policy</strong>
      </h2>
      <p data-start="2611" data-end="2745">We may update our Privacy Policy from time to time. The updated version will
        be posted on this page with a revised <strong data-start="2726" data-end="2744">Effective Date</strong>.</p>

      <hr data-start="2747" data-end="2750" class="my-4" />

      <h2 data-start="2752" data-end="2772"><strong data-start="2755" data-end="2772">9. Contact Us</strong></h2>
      <p data-start="2774" data-end="2823">If you have questions about this policy, contact:</p>
      <p data-start="2825" data-end="2907" class="text-break">
        <strong data-start="2825" data-end="2836">Motonos</strong><br data-start="2836" data-end="2839" />
        Email: <strong data-start="2846" data-end="2871">[<a class="decorated-link cursor-pointer"
            rel="noopener">contact@motonos.com</a>]</strong><br data-start="2871" data-end="2874" />
        Website: <strong data-start="2883" data-end="2907"><a class="decorated-link" href="https://motonos.com/"
            target="_new" rel="noopener" data-start="2885" data-end="2905">https://motonos.com/</a></strong>
      </p>
    </div>
  </div>
</section>
@endsection