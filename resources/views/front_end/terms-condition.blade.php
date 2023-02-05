@extends('front_end.layout')
@section('content')     
 <!-- terms-condition start -->
<section id="inner-main-content">
    <h2 class="heading">
        {{isset($page_meta['terms_conditions_title']) && $page_meta['terms_conditions_title']!='' ? $page_meta['terms_conditions_title'] : 'Terms & Conditions'}}
    </h2>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-10 col-offset-md-1">
                <div class="font-para">
                    @if(isset($page_meta['terms_conditions_description']) && $page_meta['terms_conditions_description']!='')
                        {!! $page_meta['terms_conditions_description'] !!}
                    @else
                        <p><strong>Welcome to RUTI self checkout, Inc! </strong> Before you begin using our interactive features, you must read and agree to these RUTI self checkout Terms of Services ("Terms of Services") and the following terms and conditions and policies, including any future amendments (collectively, the "Agreement"): Interactive Content Policy - How we promote free expression and responsible publishing www.rutiselfcheckout.com </p>
                        <p> RUTI self checkout may, in its sole discretion, modify or revise these Terms of Services and policies at any time, and you agree to be bound by such modifications or revisions. If you do not accept and abide by this Agreement, you may not use the RUTI self checkout's interactive services. Nothing in this Agreement shall be deemed to confer any third-party rights or benefits. Although we may attempt to notify you when major changes are made to these RUTI self checkout Terms of Services, you should periodically review the most up-to-date version. </p>
                    @endif
                    <div id="accordion">
                        @php $result = [];
                        if(isset($page_meta['terms_conditions_content']) && $page_meta['terms_conditions_content']!=''){
                            $result = json_decode($page_meta['terms_conditions_content']);
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
                                    <a class="card-link" data-toggle="collapse" href="#collapse1"><i class="fa fa-plus"></i>Description of Services</a>
                                </div>
                                <div id="collapse1" class="collapse show" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>RUTI self checkout hosts various personal journals, blogs, photos and resource library materials (collectively the "Services"). You will be responsible for all activities occurring under your username and for keeping your password secure. You understand and agree that the Services are provided to you on an as is and as available basis. RUTI self checkout disclaims all responsibility and liability for the availability, timeliness, security or reliability of the Services or any other client software. RUTI self checkout also reserves the right to modify, suspend or discontinue the Services with or without notice at any time and without any liability to you.</p>
                                        <p>You must be at least Eighteen (18) years of age to use the Services and anyone under the age of 18 must have parental permission or supervision. RUTI self checkout reserves the right to refuse service to anyone at any time without notice for any reason.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapse2"><i class="fa fa-plus"></i>Proper Use</a>
                                </div>
                                <div id="collapse2" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>You agree that you are responsible for your own use of the Services, for any posts you make, and for any consequences thereof. You agree that you will use the Services in compliance with all applicable local, state, national, and international laws, rules and regulations, including any laws regarding the transmission of technical data exported from your country of residence and all United States export control laws.</p>
                                        <p>You agree to abide by the RUTI self checkout Content Policy and the rules and restrictions therein. Although we may attempt to notify you when major changes are made to the RUTI self checkout Content Policy, you should periodically review the most up-to-date version. RUTI self checkout may, in its sole discretion, modify or revise the RUTI self checkout Content Policy at any time, and you agree to be bound by such modifications or revisions. Violation of any of the foregoing, including the RUTI self checkout Content Policy may result in immediate termination of this Agreement, and may subject you to state and federal penalties and other legal consequences. RUTI self checkout reserves the right, but shall have no obligation, to investigate your use of the Services in order to (a) determine whether a violation of the Agreement has occurred or (b) comply with any applicable law, regulation, legal process or governmental request.</p>
                                        <p>Much of the content of RUTI self checkout, Inc -- including the contents of specific postings -- is provided by and is the responsibility of the person or people who made such postings. RUTI self checkout does not monitor the content of RUTI self checkout, Inc, and takes no responsibility for such content. Instead, RUTI self checkout merely provides access to such content as a service to you.</p>
                                        <p>RUTI self checkout does not endorse, support, represent or guarantee the truthfulness, accuracy, or reliability of any communications posted via the Services or endorses any opinions expressed via the Services. You acknowledge that any reliance on material posted via the Services will be at your own risk.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapse3"><i class="fa fa-plus"></i>General Practices Regarding Use and Storage</a>
                                </div>
                                <div id="collapse3" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>You agree that RUTI self checkout has no responsibility or liability for the deletion of, or the failure to store or to transmit, any Content and other communications maintained by the Services. RUTI self checkout retains the right to create limits on use and storage at our sole discretion at any time with or without notice.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapse4"><i class="fa fa-plus"></i>Content of the Services</a>
                                </div>
                                <div id="collapse4" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>RUTI self checkout takes no responsibility for third-party content (including, without limitation, any viruses or other disabling features), nor does RUTI self checkout have any obligation to monitor such third-party content. RUTI self checkout reserves the right at all times to remove or refuse to distribute any content on the Services, such as content which violates the terms of this Agreement. RUTI self checkout also reserves the right to access, read, preserve, and disclose any information as it reasonably believes is necessary to (a) satisfy any applicable law, regulation, legal process or governmental request, (b) enforce this Agreement, including investigation of potential violations hereof, (c) detect, prevent, or otherwise address fraud, security or technical issues, (d) respond to user support requests, or (e) protect the rights, property or safety of RUTI self checkout, its users and the public. RUTI self checkout will not be responsible or liable for the exercise or non-exercise of its rights under this Agreement.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapse5"><i class="fa fa-plus"></i>Intellectual Property Rights</a>
                                </div>
                                <div id="collapse5" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>RUTI self checkout's Intellectual Property Rights. You acknowledge that RUTI self checkout owns all right, title and interest in and to the Services, including all intellectual property rights (the "RUTI self checkout Rights"). RUTI self checkout Rights are protected by U.S. and international intellectual property laws. Accordingly, you agree that you will not copy, reproduce, alter, modify, or create derivative works from the Services. You also agree that you will not use any robot, spider, other automated device, or manual process to monitor or copy any content from the Services. As described immediately below, RUTI self checkout Rights do not include third-party content used as part of the Services, including the content of communications appearing on the Services.</p>
                                        <p>Your Intellectual Property Rights. RUTI self checkout claims no ownership or control over any Content submitted, posted or displayed by you on or through RUTI self checkout services. You or a third party licensor, as appropriate, retain all patent, trademark and copyright to any Content you submit, post or display on or through RUTI self checkout services and you are responsible for protecting those rights, as appropriate. By submitting, posting or displaying Content on or through RUTI self checkout services which are intended to be available to the members of the public, you grant RUTI self checkout a worldwide, non-exclusive, royalty-free license to reproduce, publish and distribute such Content on RUTI self checkout services for the purpose of displaying and distributing RUTI self checkout services. RUTI self checkout furthermore reserves the right to refuse to accept post, display or transmit any Content in its sole discretion.</p>
                                        <p>You represent and warrant that you have all the rights, power and authority necessary to grant the rights granted herein to any Content submitted.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapse6"><i class="fa fa-plus"></i>No Resale of the Services</a>
                                </div>
                                <div id="collapse6" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>Unless expressly authorized in writing by RUTI self checkout, you agree not to reproduce, duplicate, copy, sell, trade, resell or exploit for any commercial purposes (a) any portion of the Services, (b) use of the Services, or (c) access to the Services.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapse7"><i class="fa fa-plus"></i>Representations and Warranties</a>
                                </div>
                                <div id="collapse7" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>You represent and warrant that (a) all of the information provided by you to RUTI self checkout to participate in the Services is correct and current; and (b) you have all necessary right, power and authority to enter into this Agreement and to perform the acts required of you hereunder.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapse8"><i class="fa fa-plus"></i>Termination and Suspension</a>
                                </div>
                                <div id="collapse8" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>RUTI self checkout may, in its sole discretion, at any time and for any reason, terminate the Services, terminate this Agreement, or suspend or terminate your account. In the event of termination, your account will be disabled and you may not be granted access to your account or any files or other content contained in your account although residual copies of information may remain in our system for some time for back-up purposes. Sections 2, 4-6, and 9 - 13 of the Agreement, along with applicable provisions of the general Terms of Services (including the section regarding limitation of liability), shall survive expiration or termination.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapse9"><i class="fa fa-plus"></i>Indemnification</a>
                                </div>
                                <div id="collapse9" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>You agree to hold harmless, indemnify and defend RUTI self checkout, and its officers, agents, and employees from and against any third-party claim arising from or in any way related to your use of the Services, including any liability or expense arising from all claims, losses, damages (actual and consequential), suits, judgments, litigation costs and attorneys' fees, of every kind and nature. In such a case, RUTI self checkout will provide you with written notice of such claim, suit or action.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapse10"><i class="fa fa-plus"></i>Entire Agreement</a>
                                </div>
                                <div id="collapse10" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>This Agreement constitutes the entire agreement between you and RUTI self checkout and governs your use of the Services, superseding any prior agreements between you and RUTI self checkout. You also may be subject to additional terms and conditions that may apply when you use or purchase certain other RUTI self checkout services, affiliate services, third-party content or third-party software.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapse11"><i class="fa fa-plus"></i>Waiver and Severability of Terms</a>
                                </div>
                                <div id="collapse11" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>The failure of RUTI self checkout to exercise or enforce any right or provision of the Terms of Services shall not constitute a waiver of such right or provision. If any provision of the Terms of Services is found by a court of competent jurisdiction to be invalid, the parties nevertheless agree that the court should endeavor to give effect to the parties' intentions as reflected in the provision, and the other provisions of the Terms of Services remain in full force and effect.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapse12"><i class="fa fa-plus"></i>Statute of Limitations</a>
                                </div>
                                <div id="collapse12" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>You agree that regardless of any statute or law to the contrary, any claim or cause of action arising of or related to use of RUTI self checkout services or the Terms of Services must be filed within one (1) year after such claim or cause of action arose or be forever barred.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapse13"><i class="fa fa-plus"></i>Choice of Law Jurisdiction Forum</a>
                                </div>
                                <div id="collapse13" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>These Terms of Services will be governed by and construed in accordance with the laws of the State of California, without giving effect to its conflict of laws provisions or your actual state or country of residence. Any claims, legal proceeding or litigation arising in connection with the Services will be brought solely in Los Angeles, California and you consent to the jurisdiction of such courts.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapse14"><i class="fa fa-plus"></i>Copyright Information</a>
                                </div>
                                <div id="collapse14" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>It is our policy to respond to notices of alleged infringement that comply with the Digital Millennium Copyright Act. If you believe that your copyright has been infringed on the Services, please refer to www.dmca-policy.com for information on how to file or respond to a notice of infringement.</p>
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
    

