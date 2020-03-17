<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<div class="constructor-container">
    <form id="constructor_form">
        <input type="hidden" name="IS_CONSTRUCTOR" value="1"/>
        <input type="hidden" name="PRODUCT_ID" value="constructor"/>
        <input type="hidden" name="NAME" value="<?= GetMessage("wok_box"); ?>"/>
        <input type="hidden" name="PRICE" value=""/>
        <input type="hidden" name="WEIGHT" value=""/>
        <input type="hidden" name="IMAGE"
               value="<?= CUtil::GetAdditionalFileURL(SITE_TEMPLATE_PATH . '/images/constructor-image.jpg'); ?>"/>
        <input type="hidden" name="BASE_ID"/>
        <input type="hidden" name="SOUSE_ID"/>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 col-xl-6">
                <div class="base-list  common-block">
                    <div class="title"><?= GetMessage("wok_base"); ?></div>
					<?php foreach ($arResult['BASE'] as $base): ?>
                        <div class="col-xs-6 nopadl">
                            <div class="constructor-item" data-target="BASE_ID" data-id="<?php echo $base['ID']; ?>">
                                <div class="image-cont nopadl">
                                    <div class="image"><img
                                                src="<?php echo CUtil::GetAdditionalFileURL($base['image']['src']); ?>">
                                        <svg viewBox="0 0 17 13">
                                            <path d="M54.04,48.75L50.106,53.2158H50.1044a0.9616,0.9616,0,0,1-.3215.2579v0.002a0.8512,0.8512,0,0,1-.7.0309,0.9307,0.9307,0,0,1-.2761-0.1678l-0.0017-.002-2.4466-2.3111a1.0781,1.0781,0,0,1-.3532-0.7056,1.1246,1.1246,0,0,1,.2041-0.7719h0a0.9164,0.9164,0,0,1,.06-0.0751l0.002-.0023a0.9131,0.9131,0,0,1,.5771-0.31,0.877,0.877,0,0,1,.6211.1655c0.0218,0.0156.0456,0.0349,0.0711,0.0573l1.7436,1.6948,3.3387-3.73c0.0116-.0142.0332-0.0374,0.0626-0.068a0.9059,0.9059,0,0,1,.5922-0.2792,0.8848,0.8848,0,0,1,.6137.2012l0.0008-.0017c0.0179,0.0147.0406,0.0352,0.0675,0.0612h0.0017a1.0961,1.0961,0,0,1,.3189.726,1.1129,1.1129,0,0,1-.2412.76L54.04,48.75h0Z"
                                                  transform="translate(-42 -44)"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="desc-cont nopadr">
                                    <div class="name"><?php echo $base['NAME']; ?></div>
                                    <div class="category"><?php echo $base['PREVIEW_TEXT']; ?></div>
                                </div>
                            </div>
                        </div>
					<?php endforeach; ?>
                    <div class="clearfix"></div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="base-list  common-block">
                            <div class="title"><?= GetMessage("wok_sous"); ?></div>
			                <?php foreach ($arResult['SOUSE'] as $souse): ?>
                                <div class="col-xs-6 nopadl">
                                    <div class="constructor-item" data-target="SOUSE_ID"
                                         data-id="<?php echo $souse['ID']; ?>">
                                        <div class="image-cont nopadl">
                                            <div class="image"><img src="<?php echo $souse['image']['src']; ?>">
                                                <svg viewBox="0 0 17 13">
                                                    <path d="M54.04,48.75L50.106,53.2158H50.1044a0.9616,0.9616,0,0,1-.3215.2579v0.002a0.8512,0.8512,0,0,1-.7.0309,0.9307,0.9307,0,0,1-.2761-0.1678l-0.0017-.002-2.4466-2.3111a1.0781,1.0781,0,0,1-.3532-0.7056,1.1246,1.1246,0,0,1,.2041-0.7719h0a0.9164,0.9164,0,0,1,.06-0.0751l0.002-.0023a0.9131,0.9131,0,0,1,.5771-0.31,0.877,0.877,0,0,1,.6211.1655c0.0218,0.0156.0456,0.0349,0.0711,0.0573l1.7436,1.6948,3.3387-3.73c0.0116-.0142.0332-0.0374,0.0626-0.068a0.9059,0.9059,0,0,1,.5922-0.2792,0.8848,0.8848,0,0,1,.6137.2012l0.0008-.0017c0.0179,0.0147.0406,0.0352,0.0675,0.0612h0.0017a1.0961,1.0961,0,0,1,.3189.726,1.1129,1.1129,0,0,1-.2412.76L54.04,48.75h0Z"
                                                          transform="translate(-42 -44)"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="desc-cont nopadr">
                                            <div class="name"><?php echo $souse['NAME']; ?></div>
                                            <div class="category"><?php echo $souse['PREVIEW_TEXT']; ?></div>
                                        </div>
                                    </div>
                                </div>
			                <?php endforeach; ?>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="constructor-main-buttons common-block">
                    <a href="#" data-handler="popover" data-id="constructor-ingredients" data-placement="top"
                       class="add-ingredient font-fix <?=(count($arResult['PRESETS']) == 0)?'col-xs-12 without-preset':'col-xs-6'?>">
           <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 266.533 266.533" style="enable-background:new 0 0 266.533 266.533;"
                             xml:space="preserve">
<g>
    <path d="M133.267,0C59.783,0,0,59.783,0,133.267c0,4.142,3.357,7.5,7.5,7.5s7.5-3.358,7.5-7.5C15,68.054,68.054,15,133.267,15
        s118.267,53.054,118.267,118.267s-53.054,118.267-118.267,118.267c-24.152,0-47.378-7.23-67.165-20.909
        c-19.342-13.37-34.136-31.939-42.784-53.7c-1.53-3.849-5.893-5.73-9.739-4.2c-3.85,1.53-5.73,5.89-4.2,9.74
        c9.744,24.52,26.409,45.44,48.193,60.499c22.307,15.42,48.481,23.57,75.695,23.57c73.483,0,133.267-59.783,133.267-133.267
        S206.75,0,133.267,0z"/>
    <path d="M133.267,54.529c-43.416,0-78.737,35.322-78.737,78.738s35.321,78.738,78.737,78.738s78.737-35.322,78.737-78.738
        c0-28.5-15.469-54.852-40.369-68.771c-3.617-2.023-8.185-0.729-10.206,2.887c-2.021,3.616-0.729,8.185,2.888,10.206
        c20.162,11.271,32.688,32.605,32.688,55.678c0,35.145-28.593,63.738-63.737,63.738s-63.737-28.593-63.737-63.738
        s28.593-63.738,63.737-63.738c4.143,0,7.5-3.358,7.5-7.5S137.409,54.529,133.267,54.529z"/>
    <path d="M106.531,133.267c0,14.742,11.993,26.735,26.735,26.735s26.735-11.994,26.735-26.735s-11.993-26.735-26.735-26.735
        S106.531,118.525,106.531,133.267z M145.002,133.267c0,6.471-5.265,11.735-11.735,11.735s-11.735-5.265-11.735-11.735
        s5.265-11.735,11.735-11.735S145.002,126.796,145.002,133.267z"/>
</g>
</svg>
						<?= GetMessage("wok_add_ingredients"); ?></a>
					<?php if (count($arResult['PRESETS']) > 0): ?>
                        <a href="#" data-handler="popover" data-id="constructor-presets" data-placement="top"
                           class="get-preset  col-xs-6">
                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><g><g><path d="M437.02,74.98C388.667,26.629,324.38,0,256,0S123.333,26.629,74.98,74.98C26.629,123.333,0,187.62,0,256
			s26.629,132.667,74.98,181.02C123.333,485.371,187.62,512,256,512s132.667-26.629,181.02-74.98
			C485.371,388.667,512,324.38,512,256S485.371,123.333,437.02,74.98z M256,482C131.383,482,30,380.617,30,256S131.383,30,256,30
			s226,101.383,226,226S380.617,482,256,482z"/></g></g><g><g><path d="M256,60C147.925,60,60,147.925,60,256s87.925,196,196,196s196-87.925,196-196S364.075,60,256,60z M256,422
			c-91.533,0-166-74.467-166-166S164.467,90,256,90s166,74.467,166,166S347.533,422,256,422z"/></g></g><g><g><path d="M256,120c-24.813,0-45,20.187-45,45s20.187,45,45,45s45-20.187,45-45S280.813,120,256,120z M256,180
			c-8.271,0-15-6.729-15-15s6.729-15,15-15s15,6.729,15,15S264.271,180,256,180z"/></g></g><g><g><path d="M165,211c-24.813,0-45,20.187-45,45s20.187,45,45,45s45-20.187,45-45S189.813,211,165,211z M165,271
			c-8.271,0-15-6.729-15-15s6.729-15,15-15s15,6.729,15,15S173.271,271,165,271z"/></g></g><g><g><path d="M256,302c-24.813,0-45,20.187-45,45s20.187,45,45,45s45-20.187,45-45S280.813,302,256,302z M256,362
			c-8.271,0-15-6.729-15-15s6.729-15,15-15s15,6.729,15,15S264.271,362,256,362z"/></g></g><g><g><path d="M347,211c-24.813,0-45,20.187-45,45s20.187,45,45,45s45-20.187,45-45S371.813,211,347,211z M347,271
			c-8.271,0-15-6.729-15-15s6.729-15,15-15s15,6.729,15,15S355.271,271,347,271z"/></g></g></svg>
							<?= GetMessage("wok_add_box"); ?></a>
					<?php endif; ?>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 col-xl-4 ingrs-cont-col">
                <div class="ingrs-cont common-block empty">
                    <div class="empty-icon">
                       <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 463 463" style="enable-background:new 0 0 463 463;" xml:space="preserve">
<g>
	<path d="M395.196,67.805C351.471,24.08,293.336,0,231.5,0S111.53,24.08,67.805,67.805C24.08,111.529,0,169.664,0,231.5
		s24.08,119.971,67.805,163.695C111.53,438.92,169.665,463,231.5,463s119.971-24.08,163.695-67.805
		C438.92,351.471,463,293.336,463,231.5S438.92,111.529,395.196,67.805z M384.589,384.589C343.698,425.48,289.33,448,231.5,448
		s-112.197-22.52-153.089-63.412S15,289.329,15,231.5S37.52,119.303,78.412,78.411C119.303,37.52,173.671,15,231.5,15
		s112.197,22.52,153.089,63.411C425.48,119.303,448,173.671,448,231.5S425.48,343.697,384.589,384.589z"/>
	<path d="M424.133,207.437c-2.12-4.688-4.122-9.117-4.944-13.271c-0.868-4.389-0.714-9.382-0.551-14.668
		c0.25-8.081,0.508-16.437-2.779-24.363c-3.352-8.083-9.507-13.848-15.459-19.422c-3.799-3.558-7.388-6.919-9.796-10.516
		c-2.446-3.654-4.203-8.292-6.062-13.201c-2.874-7.588-5.846-15.434-11.97-21.559c-6.124-6.124-13.969-9.096-21.557-11.971
		c-4.91-1.86-9.547-3.617-13.201-6.063c-3.598-2.409-6.959-5.998-10.518-9.798c-5.575-5.953-11.339-12.108-19.423-15.46
		c-7.928-3.288-16.285-3.03-24.367-2.781c-5.286,0.164-10.28,0.318-14.67-0.551c-4.154-0.822-8.583-2.824-13.271-4.944
		C248.445,35.649,240.375,32,231.5,32s-16.944,3.648-24.064,6.868c-4.688,2.12-9.117,4.122-13.271,4.944
		c-4.389,0.868-9.382,0.714-14.668,0.551c-8.082-0.25-16.437-0.507-24.364,2.779c-8.083,3.352-13.848,9.507-19.422,15.459
		c-3.558,3.799-6.919,7.388-10.516,9.796c-3.654,2.446-8.292,4.203-13.201,6.062c-7.588,2.874-15.435,5.846-21.559,11.97
		c-6.124,6.124-9.096,13.969-11.971,21.557c-1.86,4.91-3.617,9.547-6.063,13.201c-2.409,3.598-5.998,6.959-9.798,10.518
		c-5.953,5.575-12.108,11.339-15.46,19.423c-3.288,7.928-3.031,16.285-2.781,24.367c0.163,5.287,0.317,10.28-0.552,14.67
		c-0.822,4.154-2.824,8.583-4.944,13.271C35.649,214.555,32,222.625,32,231.5s3.648,16.944,6.868,24.064
		c2.12,4.688,4.122,9.117,4.944,13.271c0.868,4.389,0.714,9.383,0.551,14.669c-0.25,8.081-0.507,16.437,2.779,24.363
		c3.352,8.083,9.507,13.848,15.458,19.422c3.8,3.558,7.388,6.919,9.796,10.516c2.446,3.654,4.203,8.292,6.063,13.202
		c2.874,7.588,5.846,15.434,11.969,21.558s13.97,9.096,21.557,11.971c4.91,1.86,9.547,3.617,13.201,6.063
		c3.598,2.409,6.958,5.998,10.517,9.797c5.575,5.953,11.339,12.108,19.423,15.46c7.927,3.288,16.284,3.031,24.367,2.781
		c5.287-0.163,10.28-0.317,14.671,0.552c4.154,0.822,8.582,2.824,13.271,4.944c7.121,3.219,15.191,6.868,24.066,6.868
		c8.874,0,16.943-3.648,24.063-6.868c4.688-2.12,9.117-4.122,13.271-4.944c4.39-0.868,9.383-0.714,14.668-0.551
		c8.083,0.25,16.437,0.508,24.363-2.779c8.083-3.352,13.848-9.507,19.422-15.458c3.558-3.8,6.919-7.388,10.516-9.796
		c3.654-2.446,8.292-4.203,13.202-6.063c7.588-2.874,15.434-5.846,21.558-11.969c6.124-6.124,9.096-13.97,11.971-21.557
		c1.86-4.91,3.617-9.547,6.063-13.201c2.409-3.598,5.998-6.958,9.797-10.517c5.953-5.574,12.108-11.339,15.461-19.423
		c3.288-7.928,3.03-16.285,2.781-24.367c-0.163-5.287-0.317-10.281,0.551-14.67c0.822-4.154,2.824-8.582,4.944-13.271
		c3.219-7.121,6.868-15.191,6.868-24.066C431,222.626,427.352,214.557,424.133,207.437z M410.464,249.386
		c-2.376,5.256-4.833,10.69-5.991,16.54c-1.199,6.061-1.011,12.152-0.83,18.043c0.209,6.794,0.407,13.212-1.644,18.159
		c-2.113,5.094-6.847,9.527-11.858,14.221c-4.25,3.979-8.644,8.094-12.008,13.12c-3.402,5.08-5.549,10.75-7.626,16.232
		c-2.419,6.387-4.705,12.42-8.55,16.264c-3.845,3.845-9.877,6.13-16.265,8.549c-5.483,2.077-11.152,4.224-16.233,7.625
		c-5.026,3.365-9.141,7.758-13.12,12.008c-4.693,5.011-9.125,9.744-14.218,11.855c-4.945,2.051-11.361,1.854-18.155,1.643
		c-5.89-0.182-11.982-0.37-18.043,0.829c-5.849,1.157-11.284,3.614-16.54,5.991C243.088,413.312,237.141,416,231.5,416
		c-5.642,0-11.589-2.689-17.886-5.536c-5.256-2.376-10.69-4.833-16.539-5.991c-3.846-0.761-7.703-0.963-11.515-0.963
		c-2.195,0-4.376,0.067-6.529,0.134c-6.797,0.209-13.213,0.407-18.159-1.644c-5.094-2.113-9.527-6.847-14.221-11.858
		c-3.979-4.249-8.094-8.643-13.12-12.008c-5.08-3.401-10.75-5.549-16.232-7.626c-6.387-2.419-12.42-4.705-16.264-8.55
		c-3.845-3.845-6.13-9.877-8.549-16.265c-2.077-5.483-4.224-11.152-7.625-16.233c-3.365-5.026-7.758-9.141-12.008-13.12
		c-5.011-4.693-9.744-9.125-11.855-14.219c-2.051-4.945-1.853-11.361-1.643-18.154c0.182-5.891,0.37-11.983-0.829-18.043
		c-1.157-5.849-3.614-11.283-5.991-16.54C49.689,243.088,47,237.141,47,231.5s2.689-11.589,5.536-17.885
		c2.376-5.256,4.834-10.691,5.991-16.54c1.199-6.061,1.011-12.152,0.83-18.043c-0.209-6.795-0.407-13.212,1.644-18.159
		c2.113-5.094,6.846-9.527,11.858-14.221c4.25-3.979,8.644-8.094,12.008-13.12c3.402-5.081,5.549-10.75,7.626-16.233
		c2.419-6.387,4.705-12.419,8.55-16.264c3.845-3.845,9.878-6.129,16.265-8.549c5.482-2.076,11.152-4.224,16.232-7.625
		c5.026-3.365,9.141-7.758,13.12-12.007c4.693-5.011,9.125-9.744,14.219-11.856c4.946-2.05,11.362-1.851,18.155-1.643
		c5.89,0.183,11.982,0.37,18.043-0.829c5.849-1.157,11.283-3.614,16.54-5.991C219.913,49.689,225.859,47,231.5,47
		s11.589,2.689,17.885,5.536c5.256,2.376,10.691,4.834,16.54,5.991c6.06,1.199,12.15,1.011,18.043,0.83
		c6.795-0.21,13.212-0.408,18.159,1.644c5.094,2.113,9.527,6.847,14.22,11.858c3.979,4.25,8.095,8.644,13.121,12.009
		c5.081,3.402,10.75,5.549,16.233,7.626c6.387,2.419,12.419,4.705,16.264,8.55s6.129,9.878,8.549,16.265
		c2.076,5.482,4.224,11.152,7.625,16.232c3.365,5.026,7.758,9.141,12.007,13.12c5.011,4.693,9.744,9.125,11.856,14.219
		c2.05,4.945,1.852,11.361,1.643,18.155c-0.182,5.891-0.37,11.982,0.829,18.042c1.157,5.849,3.614,11.284,5.991,16.54
		c2.846,6.296,5.535,12.243,5.535,17.883C416,237.142,413.312,243.089,410.464,249.386z"/>
	<path d="M183.5,167c17.369,0,31.5-14.131,31.5-31.5S200.87,104,183.5,104S152,118.131,152,135.5S166.131,167,183.5,167z M183.5,119
		c9.098,0,16.5,7.402,16.5,16.5s-7.402,16.5-16.5,16.5s-16.5-7.402-16.5-16.5S174.402,119,183.5,119z"/>
	<path d="M351,191.5c0-17.369-14.131-31.5-31.5-31.5S288,174.131,288,191.5s14.131,31.5,31.5,31.5S351,208.869,351,191.5z
		 M319.5,208c-9.098,0-16.5-7.402-16.5-16.5s7.402-16.5,16.5-16.5s16.5,7.402,16.5,16.5S328.599,208,319.5,208z"/>
	<path d="M271.5,304c-17.369,0-31.5,14.131-31.5,31.5c0,17.369,14.131,31.5,31.5,31.5S303,352.87,303,335.5
		C303,318.131,288.87,304,271.5,304z M271.5,352c-9.098,0-16.5-7.402-16.5-16.5s7.402-16.5,16.5-16.5s16.5,7.402,16.5,16.5
		S280.599,352,271.5,352z"/>
	<path d="M183,263.5c0-17.369-14.131-31.5-31.5-31.5c-17.37,0-31.5,14.131-31.5,31.5s14.131,31.5,31.5,31.5
		C168.87,295,183,280.869,183,263.5z M151.5,280c-9.099,0-16.5-7.402-16.5-16.5s7.402-16.5,16.5-16.5c9.098,0,16.5,7.402,16.5,16.5
		S160.599,280,151.5,280z"/>
	<path d="M263,247.5c0-12.958-10.542-23.5-23.5-23.5S216,234.542,216,247.5s10.542,23.5,23.5,23.5S263,260.458,263,247.5z
		 M239.5,256c-4.687,0-8.5-3.813-8.5-8.5s3.813-8.5,8.5-8.5s8.5,3.813,8.5,8.5S244.188,256,239.5,256z"/>
	<path d="M271.5,143c12.958,0,23.5-10.542,23.5-23.5S284.458,96,271.5,96S248,106.542,248,119.5S258.542,143,271.5,143z M271.5,111
		c4.687,0,8.5,3.813,8.5,8.5s-3.813,8.5-8.5,8.5s-8.5-3.813-8.5-8.5S266.813,111,271.5,111z"/>
	<path d="M343.5,248c-12.958,0-23.5,10.542-23.5,23.5s10.542,23.5,23.5,23.5s23.5-10.542,23.5-23.5S356.458,248,343.5,248z
		 M343.5,280c-4.687,0-8.5-3.813-8.5-8.5s3.813-8.5,8.5-8.5s8.5,3.813,8.5,8.5S348.188,280,343.5,280z"/>
	<path d="M183.5,320c-12.958,0-23.5,10.542-23.5,23.5s10.542,23.5,23.5,23.5s23.5-10.542,23.5-23.5S196.458,320,183.5,320z
		 M183.5,352c-4.687,0-8.5-3.813-8.5-8.5s3.813-8.5,8.5-8.5s8.5,3.813,8.5,8.5S188.188,352,183.5,352z"/>
	<path d="M119.5,207c12.958,0,23.5-10.542,23.5-23.5S132.458,160,119.5,160S96,170.542,96,183.5S106.542,207,119.5,207z M119.5,175
		c4.687,0,8.5,3.813,8.5,8.5s-3.813,8.5-8.5,8.5s-8.5-3.813-8.5-8.5S114.813,175,119.5,175z"/>
	<path d="M202.854,184.792c-3.703-1.852-8.209-0.351-10.062,3.354s-0.351,8.21,3.354,10.062l16,8
		c1.077,0.539,2.221,0.793,3.348,0.793c2.751,0,5.4-1.52,6.714-4.147c1.853-3.705,0.351-8.21-3.354-10.062L202.854,184.792z"/>
	<path d="M247.5,183c1.919,0,3.839-0.732,5.303-2.197l8-8c2.929-2.929,2.929-7.678,0-10.606c-2.929-2.929-7.678-2.929-10.606,0l-8,8
		c-2.929,2.929-2.929,7.678,0,10.606C243.662,182.268,245.581,183,247.5,183z"/>
	<path d="M220.804,290.197l-8-8c-2.929-2.929-7.678-2.929-10.606,0c-2.929,2.929-2.929,7.678,0,10.606l8,8
		c1.464,1.464,3.384,2.197,5.303,2.197s3.839-0.732,5.303-2.197C223.733,297.875,223.733,293.125,220.804,290.197z"/>
	<path d="M292.804,250.197c-2.929-2.929-7.678-2.929-10.606,0c-2.929,2.929-2.929,7.678,0,10.606l8,8
		c1.464,1.464,3.384,2.197,5.303,2.197s3.839-0.732,5.303-2.197c2.929-2.929,2.929-7.678,0-10.606L292.804,250.197z"/>
	<path d="M380.146,208.792l-16,8c-3.705,1.852-5.207,6.357-3.354,10.062c1.314,2.628,3.962,4.147,6.714,4.147
		c1.127,0,2.271-0.255,3.348-0.793l16-8c3.705-1.852,5.207-6.357,3.354-10.062C388.356,208.441,383.852,206.938,380.146,208.792z"/>
	<path d="M100.803,234.197c-2.929-2.929-7.678-2.929-10.606,0l-8,8c-2.929,2.929-2.929,7.678,0,10.606
		C83.661,254.268,85.581,255,87.5,255s3.839-0.732,5.303-2.197l8-8C103.732,241.875,103.732,237.125,100.803,234.197z"/>
	<path d="M218.197,92.803C219.662,94.268,221.581,95,223.5,95s3.839-0.732,5.303-2.197c2.929-2.929,2.929-7.678,0-10.606l-8-8
		c-2.929-2.929-7.678-2.929-10.606,0c-2.929,2.929-2.929,7.678,0,10.606L218.197,92.803z"/>
	<path d="M223.5,360c-4.142,0-7.5,3.358-7.5,7.5v8c0,4.142,3.358,7.5,7.5,7.5s7.5-3.358,7.5-7.5v-8
		C231,363.358,227.643,360,223.5,360z"/>
	<path d="M330.197,314.197l-8,8c-2.929,2.929-2.929,7.678,0,10.606c1.464,1.464,3.384,2.197,5.303,2.197s3.839-0.732,5.303-2.197
		l8-8c2.929-2.929,2.929-7.678,0-10.606C337.875,311.269,333.126,311.269,330.197,314.197z"/>
	<path d="M124.803,314.197c-2.929-2.929-7.678-2.929-10.606,0c-2.929,2.929-2.929,7.678,0,10.606l8,8
		c1.464,1.464,3.384,2.197,5.303,2.197s3.839-0.732,5.303-2.197c2.929-2.929,2.929-7.678,0-10.606L124.803,314.197z"/>
	<path d="M322.197,124.803c1.464,1.464,3.384,2.197,5.303,2.197s3.839-0.732,5.303-2.197c2.929-2.929,2.929-7.678,0-10.606l-8-8
		c-2.929-2.929-7.678-2.929-10.606,0c-2.929,2.929-2.929,7.678,0,10.606L322.197,124.803z"/>
	<path d="M351.5,159c1.97,0,3.91-0.8,5.3-2.2c1.4-1.39,2.2-3.33,2.2-5.3c0-1.97-0.8-3.91-2.2-5.3c-1.39-1.4-3.33-2.2-5.3-2.2
		c-1.97,0-3.91,0.8-5.3,2.2c-1.4,1.39-2.2,3.33-2.2,5.3c0,1.97,0.8,3.91,2.2,5.3C347.59,158.2,349.53,159,351.5,159z"/>
	<path d="M258.2,202.2c-1.4,1.39-2.2,3.33-2.2,5.3c0,1.97,0.8,3.91,2.2,5.3c1.39,1.4,3.33,2.2,5.3,2.2c1.97,0,3.91-0.8,5.3-2.2
		c1.4-1.39,2.2-3.33,2.2-5.3c0-1.97-0.8-3.91-2.2-5.3c-1.39-1.4-3.33-2.2-5.3-2.2C261.53,200,259.59,200.8,258.2,202.2z"/>
	<path d="M162.2,210.2c-1.4,1.39-2.2,3.32-2.2,5.3s0.8,3.91,2.2,5.3c1.39,1.4,3.33,2.2,5.3,2.2c1.97,0,3.91-0.8,5.3-2.2
		c1.4-1.39,2.2-3.33,2.2-5.3c0-1.97-0.8-3.91-2.2-5.3c-1.39-1.4-3.32-2.2-5.3-2.2S163.59,208.8,162.2,210.2z"/>
	<path d="M127.5,135c1.97,0,3.91-0.8,5.3-2.2c1.4-1.39,2.2-3.33,2.2-5.3c0-1.98-0.8-3.91-2.2-5.3c-1.39-1.4-3.33-2.2-5.3-2.2
		c-1.98,0-3.91,0.8-5.3,2.2c-1.4,1.39-2.2,3.32-2.2,5.3c0,1.97,0.8,3.91,2.2,5.3C123.59,134.2,125.53,135,127.5,135z"/>
	<path d="M250.2,282.2c-1.4,1.39-2.2,3.33-2.2,5.3c0,1.97,0.8,3.91,2.2,5.3c1.39,1.4,3.33,2.2,5.3,2.2c1.98,0,3.91-0.8,5.3-2.2
		c1.4-1.39,2.2-3.33,2.2-5.3c0-1.97-0.8-3.91-2.2-5.3c-1.39-1.4-3.32-2.2-5.3-2.2C253.53,280,251.59,280.8,250.2,282.2z"/>
	<path d="M255.5,376c-1.97,0-3.91,0.8-5.3,2.2c-1.4,1.39-2.2,3.33-2.2,5.3c0,1.98,0.8,3.91,2.2,5.3c1.39,1.4,3.32,2.2,5.3,2.2
		s3.91-0.8,5.3-2.2c1.4-1.39,2.2-3.32,2.2-5.3c0-1.97-0.8-3.91-2.2-5.3C259.41,376.8,257.48,376,255.5,376z"/>
	<path d="M103.5,272c-1.97,0-3.91,0.8-5.3,2.2c-1.4,1.39-2.2,3.33-2.2,5.3c0,1.97,0.8,3.91,2.2,5.3c1.39,1.4,3.33,2.2,5.3,2.2
		c1.97,0,3.91-0.8,5.3-2.2c1.4-1.39,2.2-3.33,2.2-5.3c0-1.97-0.8-3.91-2.2-5.3C107.41,272.8,105.47,272,103.5,272z"/>
</g>
</svg> </svg>
                    </div>
                    <div class="col-xs-12">
                        <div class="constructor-name-title"><?= GetMessage("wok_box"); ?></div>
                    </div>
                    <div class="constructor-base-error">
                        <div class="col-xs-12">
                            <span class="wok_error_choose"><?= GetMessage('wok_error_choose') ?></span>
                            <span class="wok_error_base"><?= GetMessage('wok_error_base') ?></span>
                            <span class="wok_error_and"><?= GetMessage('wok_error_and') ?></span>
                            <span class="wok_error_souse"><?= GetMessage('wok_error_souse') ?></span>
                        </div>
                    </div>
                    <div class="ingredients-list col-xs-12"></div>
                    <div class="clearfix"></div>
                    <div class="ingredients-list-footer">
                        <div class="col-xs-12 constructor-summary font-fix"></span>
                            <div class="weight">
                                <span><div><?= GetMessage("wok_total_weight"); ?></div></span>
                                <span>
                                    <span class="constructor-summary-value">0</span> <span><?= GetMessage("weight"); ?></span>
                                </span>
                            </div>

                            <div class="sum-value">
                                <span><div><?= GetMessage("wok_total"); ?></div></span>
                                <span>
                                    <span class="constructor-summary-value">0</span>
                                    <span class="currency"><?= CURRENCY_FONT; ?></span>
                                </span>
                            </div>
                        </div>
                        <div class="constructor-actions">
                            <button disabled="disabled"
                                    class="add-to-cart-constructor"><?= GetMessage("wok_add_to_basket"); ?></button>
                            <button class="clear-constructor"><?= GetMessage("wok_clear_form"); ?></button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>
<div style="display: none">
    <div id="constructor-change-amount" class="bd-popup">
        <div class="ingredient-name"></div>
        <div class="ingredient-amount">
            <button type="button" class="change-cons-amount-btn minus"
                    onclick="changeIngredientAmount(window.edit_ingredient,0)">-
            </button>
            <input type="text" value="1"/>
            <button type="button" class="change-cons-amount-btn plus"
                    onclick="changeIngredientAmount(window.edit_ingredient,1)">+
            </button>
        </div>
        <div class="ingredient-footer">
            <a href="#" onclick="removeFromConstructor(); return false;"><?= GetMessage('remove_preset'); ?></a>
        </div>
    </div>
    <div id="constructor-ingredients" class="bd-popup">
        <div class="section ingredients">
            <div class="new-ingredient">
                <div class="ingredient-categories">
                    <div class="bd-select">
                        <div class="label"><?= GetMessage('ing_label') ?></div>
                        <select class="cs-select cs-skin-slide constructor_cats_select">
                            <option value="null"><?= GetMessage("wok_chose_category"); ?></option>
				            <?php foreach ($arResult['FILLING_CATS'] as $key => $filling_cat): ?>
                                <option <?php if ($key == 0): ?>selected<?php endif; ?>
                                        value="<?php echo $filling_cat['ID']; ?>"><?php echo $filling_cat['NAME']; ?></option>
				            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="select-ingredients-cont">
                    <div class="select-ingredients-list scrollbar-macosx">
			            <?php foreach ($arResult['FILLING'] as $filling): ?>
                            <div data-id="<?php echo $filling['ID']; ?>" class="ingredient-item"
                                 data-section="<?php echo $filling['IBLOCK_SECTION_ID']; ?>"
                                 style="<?php if ($arResult['FILLING_CATS'][0]['ID'] !== $filling['IBLOCK_SECTION_ID']): ?>display: none;<?php endif; ?>">
                                <div class="name"><?php echo $filling['NAME']; ?></div>

                            </div>
			            <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<?php if (count($arResult['PRESETS']) > 0): ?>
    <div id="constructor-presets" class="bd-popup">
        <div class="section presets">

            <div class="select-preset-list scrollbar-macosx">
				<?php foreach ($arResult['PRESETS'] as $preset): ?>
                    <div class="preset-item row"
                         data-filling="<?php echo implode(',', $preset['PROPS']['INGREDIENTS']['VALUE']); ?>"
                         data-id="<?php echo $preset['ID']; ?>"
                         data-big-image="<?php echo CUtil::GetAdditionalFileURL($preset['big_image']['src']); ?>">
                        <div class="col-xs-4 nopad">
                            <div class="image">
                                <div class="active-label">
                                                                        <svg viewBox="0 0 17 13">
                                        <path d="M54.04,48.75L50.106,53.2158H50.1044a0.9616,0.9616,0,0,1-.3215.2579v0.002a0.8512,0.8512,0,0,1-.7.0309,0.9307,0.9307,0,0,1-.2761-0.1678l-0.0017-.002-2.4466-2.3111a1.0781,1.0781,0,0,1-.3532-0.7056,1.1246,1.1246,0,0,1,.2041-0.7719h0a0.9164,0.9164,0,0,1,.06-0.0751l0.002-.0023a0.9131,0.9131,0,0,1,.5771-0.31,0.877,0.877,0,0,1,.6211.1655c0.0218,0.0156.0456,0.0349,0.0711,0.0573l1.7436,1.6948,3.3387-3.73c0.0116-.0142.0332-0.0374,0.0626-0.068a0.9059,0.9059,0,0,1,.5922-0.2792,0.8848,0.8848,0,0,1,.6137.2012l0.0008-.0017c0.0179,0.0147.0406,0.0352,0.0675,0.0612h0.0017a1.0961,1.0961,0,0,1,.3189.726,1.1129,1.1129,0,0,1-.2412.76L54.04,48.75h0Z"
                                              transform="translate(-42 -44)"></path>
                                    </svg>
                                </div>
                                <img src="<?php echo CUtil::GetAdditionalFileURL($preset['image']['src']); ?>">
                            </div>
                        </div>
                        <div class="col-xs-8">
                            <div class="name"><?php echo $preset['NAME']; ?></div>
                            <div class="description"><?php echo $preset['PREVIEW_TEXT'] ?></div>
                            <div class="preset-footer">
                                <div class="price"><?php echo $preset['price_s'] ?><span
                                            class="currency"><?= CURRENCY_FONT; ?></span></div>
                                <div class="weight"><?php echo $preset['weight_s'] ?> <?= GetMessage("weight"); ?></div>
                                <div class="preset-actions">
                                    <a href="#"
                                       class="preset-item-btn choose-preset"><?= GetMessage('add_preset') ?></a>
                                    <a href="#"
                                       class="preset-item-btn remove-preset"><?= GetMessage('remove_preset') ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
				<?php endforeach; ?>

            </div>
        </div>
            </div>
</div>
<?php endif; ?>

</div>
