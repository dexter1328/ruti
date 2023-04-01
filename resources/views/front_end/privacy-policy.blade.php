@extends('front_end.layout')
@section('content')
    <div style="clear:both;"></div>
 <!-- terms-condition start -->
 <section id="inner-main-content">
    <h2 class="heading" style="margin:25px;">
        {{isset($page_meta['privacy_policy_title']) && $page_meta['privacy_policy_title']!='' ? $page_meta['privacy_policy_title'] : 'Privacy Policy'}}
    </h2>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-10 col-offset-md-1">
                <div class="font-para">
                    @if(isset($page_meta['privacy_policy_description']) && $page_meta['privacy_policy_description']!='')
                        {!! $page_meta['privacy_policy_description'] !!}
                    @else
                        <p>The following privacy policy govern all use of the naturecheckout.com website and all content, services and products available through the website, including, but not limited to, the client area (collectively referred to as the Site).</p>
                        <p>The Site is owned and operated by Nature checkout Inc. The Site is offered subject to your acceptance without modification of all of the terms contained herein and all other operating rules, policies (including, without limitation, Nature checkout Inc's Privacy Policy) and procedures that may be published from time to time on this Site by Nature checkout Inc (collectively, the "Agreement").</p>
                        <p>Please read this Agreement carefully before accessing or using the Site. By accessing or using any part of the web site, you agree to become bound by the terms of this agreement. If you do not agree to all the terms and conditions of this agreement, then you may not access the Site or use any services. If these terms and conditions are considered an offer by Nature checkout Inc, acceptance is expressly limited to these terms. Nature checkout Inc is available to individuals of all ages provided they are a part of a family.</p>
                    @endif
                    <div id="accordion">
                        @php $result = [];
                        if(isset($page_meta['privacy_policy_content']) && $page_meta['privacy_policy_content']!=''){
                            $result = json_decode($page_meta['privacy_policy_content']);
                        }
                        @endphp
                        @if(!empty($result))
                            @php $i = 1; @endphp
                            @foreach($result as $row)
                                <div class="card">
                                    <div class="card-header">
                                        <a class="card-link" data-toggle="collapse" href="#collapse{{$i}}"><i class="fa fa-plus"></i>{{$row->title}}</a>
                                    </div>
                                    <div id="collapse{{$i}}" class="collapse @if($i==1) show @endif" data-parent="#accordion">
                                        <div class="card-body">
                                            {!! $row->description !!}
                                        </div>
                                    </div>
                                </div>
                                @php $i++; @endphp
                            @endforeach
                        @else
                            <div class="card">
                                <div class="card-header">
                                    <a class="card-link" data-toggle="collapse" href="#collapse1"><i class="fa fa-plus"></i>Contribution to website</a>
                                </div>
                                <div id="collapse1" class="collapse show" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>If you leave comments anywhere on the Site, post material to the Site, post links on the Site, or otherwise make (or allow any third party to make) material available by means of the Site (any such material, "Content"), You are entirely responsible for the content of, and any harm resulting from, that Content. That is the case regardless of whether the Content in question constitutes text, graphics, audio, or computer software. By making Content available, you represent and warrant that:</p>
                                        <p>Downloading, copying and use of the Content will not infringe the proprietary rights, including but not limited to the copyright, patent, trademark or trade secret rights, of any third party</p>
                                        <p>You have fully complied with any third-party licenses relating to the Content, and have done all things necessary to successfully pass through to end users any required terms</p>
                                        <p>The Content does not contain or install any viruses, worms, malware, trojan horses or other harmful or destructive content The Content is not spam, is not machine or randomly generated, and does not contain unethical or unwanted commercial content designed to drive traffic to third party sites or boost the search engine rankings of third party sites, or to further unlawful acts (such as phishing) or mislead recipients as to the source of the material (such as spoofing)</p>
                                        <p>The Content is not pornographic, libelous or defamatory, does not contain threats or incite violence towards individuals or entities, and does not violate the privacy or publicity rights of any third party</p>
                                        <p>By submitting Content to Nature checkout Inc for inclusion on our Site, you grant Nature checkout Inc. a world-wide, royalty-free, and non-exclusive license to reproduce, modify, adapt and publish the Content for the purpose of displaying, distributing, promoting, marketing or any other lawful use.</p>
                                        <p>Without limiting any of those representations or warranties, Nature checkout Inc has the right (though not the obligation) to, in Nature checkout Inc's sole discretion (i) refuse or remove any content that, in Nature checkout Inc's reasonable opinion, violates any policy or is in any way harmful or objectionable, or (ii) terminate or deny access to and use of the Site to any individual or entity for any reason, in Nature checkout Inc's sole discretion. Nature checkout Inc will have no obligation to provide a refund of any amounts previously paid under these circumstances.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapse2"><i class="fa fa-plus"></i>What information do we collect?</a>
                                </div>
                                <div id="collapse2" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>We may collect personally identifiable information from you in a variety of ways, including through online forms for ordering products and services, and other instances where you are invited to volunteer such information, including, but not limited to, when you register on our site, place an order or subscribe to our newsletter. When ordering or registering on our site, as appropriate, you may be asked to enter your name, e-mail address, mailing address, phone number or credit card information.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapse3"><i class="fa fa-plus"></i>What do we use your information for?</a>
                                </div>
                                <div id="collapse3" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>Any of the information we collect from you may be used to personalize your experience, improve our website, improve customer service, process transactions, send periodic emails. The email address you provide for order processing, will only be used to send you information and updates pertaining to your order. If you decide to opt-in to our mailing list, you will receive emails that may include company news, updates, related product or service information, etc. If at any time you would like to unsubscribe from receiving future emails, we include detailed unsubscribe instructions at the bottom of each email.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapse4"><i class="fa fa-plus"></i>How do we protect your information?</a>
                                </div>
                                <div id="collapse4" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>We implement a variety of security measures to maintain the safety of your personal information when you place an order or access your personal information</p>
                                        <p>We offer the use of a secure server. All supplied sensitive/credit information is transmitted via Secure Socket Layer (SSL) technology and then encrypted into our payment gateway providers database only to be accessible by those authorized with special access rights to such systems, and are required to keep the information confidential. After a transaction, your private information (credit cards, social security numbers, financials, etc.) will not be stored on our servers.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapse5"><i class="fa fa-plus"></i>Payments and refunds</a>
                                </div>
                                <div id="collapse5" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>The Site offers products and services for sale. The Site does not handle payments for these products directly, but rather refers these payments to a secure third-party payment processor which handles all aspects of the payment process. Any payment issues or disputes should be resolved directly with the payment processor. Once we have been notified by the payment processor that a payment has been made, and that the payment has successfully passed a fraud review, access will be granted to the product or service being purchased as soon as possible, however we make no guarantees of timeliness or immediacy. Free accounts are provided with a limited access to the Site that allows the user to test all available services prior to making a payment and determine if the offered services meet user’s needs. You may request a refund within 7 days of the payment only if your browser does not support JavaScript and you're not able to use our privacy policy generator, otherwise no refunds will be offered. Note that our system keeps track of your browser name, version and JavaScript support so we will verify each request for legitimacy.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapse6"><i class="fa fa-plus"></i>Responsibility of website visitors</a>
                                </div>
                                <div id="collapse6" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>By operating the Site, Nature checkout Inc does not represent or imply that it endorses any or all of the contributed content, or that it believes such material to be accurate, useful or non-harmful. You are responsible for taking precautions as necessary to protect yourself and your computer systems from viruses, worms, trojan horses, and other harmful or destructive content. The Site may contain content that is offensive, indecent, or otherwise objectionable, as well as content containing technical inaccuracies, typographical mistakes, and other errors. Nature checkout Inc disclaims any responsibility for any harm resulting from the use by visitors of the Site.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapse7"><i class="fa fa-plus"></i>Do we disclose any information to outside parties?</a>
                                </div>
                                <div id="collapse7" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>We do not sell, trade, or otherwise transfer to outside parties your personally identifiable information, except to provide products or services you've requested. This does not include trusted third parties who assist us in operating our website, conducting our business, or servicing you, so long as those parties agree to keep this information confidential. We may also release your information when we believe release is appropriate to comply with the law, enforce our site policies, or protect ours or others rights, property, or safety. However, non-personally identifiable visitor information may be provided to other parties for marketing, advertising, or other uses.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapse8"><i class="fa fa-plus"></i>Copyright infringement and DMCA policy</a>
                                </div>
                                <div id="collapse8" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>As Nature checkout Inc asks others to respect its intellectual property rights, it respects the intellectual property rights of others. If you believe that material located on or linked to by the Site violates your copyright, you are encouraged to notify Nature checkout Inc in accordance with common DMCA policies. Nature checkout Inc will respond to all such notices, including as required or appropriate by removing the infringing material or disabling all links to the infringing material. In the case of a visitor who may infringe or repeatedly infringes the copyrights or other intellectual property rights of Nature checkout Inc or others, Nature checkout Inc may, in its discretion, terminate or deny access to and use of the Site. In the case of such termination, Nature checkout Inc will have no obligation to provide a refund of any amounts previously paid to Nature checkout Inc. You further agree not to change or delete any proprietary notices from materials downloaded from the site. You must also retain our copyright notice in the privacy policy you create, unless you have purchased a premium membership in which case you may remove our copyright notice from your privacy statement.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapse9"><i class="fa fa-plus"></i>Do we use cookies?</a>
                                </div>
                                <div id="collapse9" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>Yes, we use cookies (which are small pieces of information that your browser stores on your computer's hard drive) to help us remember and process the items in your shopping cart, understand and save your preferences for future visits and compile aggregate data about site traffic and site interaction so that we can offer better site experiences and tools in the future. We may contract with third-party service providers to assist us in better understanding our site visitors. These service providers are not permitted to use the information collected on our behalf except to help us conduct and improve our business.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapse10"><i class="fa fa-plus"></i>Third party links</a>
                                </div>
                                <div id="collapse10" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>Our site may contain links to third party sites. These third party sites have separate and independent privacy policies. We therefore have no responsibility or liability for the content and activities of these linked sites. Nonetheless, we seek to protect the integrity of our site and welcome any feedback about these sites.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapse11"><i class="fa fa-plus"></i>Intellectual property</a>
                                </div>
                                <div id="collapse11" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>This Agreement does not transfer from Nature checkout Inc to you any Nature checkout Inc or third party intellectual property, and all right, title and interest in and to such property will remain (as between the parties) solely with Nature checkout Inc. Nature checkout Inc logo, and all other trademarks, service marks, graphics and logos used in connection with Nature checkout Inc, or the Site are trademarks or registered trademarks of Nature checkout Inc or Nature checkout Inc's licensors. Other trademarks, service marks, graphics and logos used in connection with the Site may be the trademarks of other third parties. Your use of the Site grants you no right or license to reproduce or otherwise use any Nature checkout Inc or third-party trademarks.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapse12"><i class="fa fa-plus"></i>Changes</a>
                                </div>
                                <div id="collapse12" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>Nature checkout Inc reserves the right, at its sole discretion, to modify or replace any part of this Agreement. It is your responsibility to check this Agreement periodically for changes. Your continued use of or access to the Site following the posting of any changes to this Agreement constitutes acceptance of those changes. Nature checkout Inc may also, in the future, offer new services and/or features through the Site (including, the release of new tools and resources). Such new features and/or services shall be subject to the terms and conditions of this Agreement.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapse13"><i class="fa fa-plus"></i>Limitation of liability</a>
                                </div>
                                <div id="collapse13" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>In no event will Nature checkout Inc, or its suppliers or licensors, be liable with respect to any subject matter of this agreement under any contract, negligence, strict liability or other legal or equitable theory for: (i) any special, incidental or consequential damages; (ii) the cost of procurement or substitute products or services; (iii) for interruption of use or loss or corruption of data; or (iv) for any amounts that exceed the fees paid by you to Nature checkout Inc under this agreement. Nature checkout Inc shall have no liability for any failure or delay due to matters beyond their reasonable control. The foregoing shall not apply to the extent prohibited by applicable law. Nature checkout Inc shall not be liable for any special or consequential damages that result from the use of, or the inability to use, the services and products offered on this site, or the performance of the services and products.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapse14"><i class="fa fa-plus"></i>General representation and warranty</a>
                                </div>
                                <div id="collapse14" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>You represent and warrant that (i) your use of the Site will be in strict accordance with the Nature checkout Inc Privacy Policy, with this Agreement and with all applicable laws and regulations (including without limitation any local laws or regulations in your country, state, city, or other governmental area, regarding online conduct and acceptable content, and including all applicable laws regarding the transmission of technical data exported from the United States or the country in which you reside) and (ii) your use of the Site will not infringe or misappropriate the intellectual property rights of any third party.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapse15"><i class="fa fa-plus"></i>Changes to our terms and privacy policies</a>
                                </div>
                                <div id="collapse15" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>From time to time we may make adjustments to this policy. Changes will be made at our sole discretion. Site's users are encouraged to check this policy for such changes. Your continued use of this site following changes to this policy constitutes your acceptance of the changes.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapse16"><i class="fa fa-plus"></i>Contacting us</a>
                                </div>
                                <div id="collapse16" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>Any questions about this policy should be addressed to us via our contact form.<br> These policies have been last modified on January 4, 2019 </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
 @endsection
