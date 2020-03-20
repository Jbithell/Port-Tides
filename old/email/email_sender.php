<?php
require_once '../login.php';
date_default_timezone_set("Europe/London");
function returnhtml($startdate) {
	global $db_hostname, $db_username, $db_password, $db_database;
	$conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
	// Check connection
	if ($conn->connect_error) {
		 die("Connection failed, please contact support");
	} 
	$sql = "SELECT * FROM porttides_ukho_adjusted WHERE (date BETWEEN '" . date('Y-m-d', strtotime($startdate)) . "' AND '" . date('Y-m-d', strtotime($startdate . " +9days")) . "')";
	$result = $conn->query($sql);
	
	$tides = array();
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$tides[] = array($row["date"], $row["tide1time"], $row["tide2time"], $row["tide1height"], $row["tide2height"]);
		}
	} else {
		exit;
	}
	$html = '<html><head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				<meta name="viewport" content="width=device-width, initial-scale=1.0">
				<style type="text/css">
					/* Client-specific Styles */
					#outlook a {padding:0;} /* Force Outlook to provide a "view in browser" menu link. */
					body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}
					/* Prevent Webkit and Windows Mobile platforms from changing default font sizes, while not breaking desktop design. */
					.ExternalClass {width:100%;} /* Force Hotmail to display emails at full width */
					.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;} /* Force Hotmail to display normal line spacing.*/
					#backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
					img {outline:none; text-decoration:none;border:none; -ms-interpolation-mode: bicubic;}
					a img {border:none;}
					.image_fix {display:block;}
					p {margin: 0px 0px !important;}
					table td {border-collapse: collapse;}
					table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }
					a {color: #0a8cce;text-decoration: none;text-decoration:none!important;}
					/*STYLES*/
					table[class=full] { width: 100%; clear: both; }
					/*IPAD STYLES*/
					@media only screen and (max-width: 640px) {
					a[href^="tel"], a[href^="sms"] {
					text-decoration: none;
					color: #0a8cce; /* or whatever your want */
					pointer-events: none;
					cursor: default;
					}
					.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
					text-decoration: default;
					color: #0a8cce !important;
					pointer-events: auto;
					cursor: default;
					}
					table[class=devicewidth] {width: 440px!important;text-align:center!important;}
					table[class=devicewidthinner] {width: 420px!important;text-align:center!important;}
					img[class=banner] {width: 440px!important;height:220px!important;}
					img[class=colimg2] {width: 440px!important;height:220px!important;}
					}
					/*IPHONE STYLES*/
					@media only screen and (max-width: 480px) {
					a[href^="tel"], a[href^="sms"] {
					text-decoration: none;
					color: #0a8cce; /* or whatever your want */
					pointer-events: none;
					cursor: default;
					}
					.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
					text-decoration: default;
					color: #0a8cce !important; 
					pointer-events: auto;
					cursor: default;
					}
					table[class=devicewidth] {width: 280px!important;text-align:center!important;}
					table[class=devicewidthinner] {width: 260px!important;text-align:center!important;}
					img[class=banner] {width: 280px!important;height:140px!important;}
					img[class=colimg2] {width: 280px!important;height:140px!important;}
					}
				</style>
			</head>
			<body>
				<!-- Start of preheader -->
				<!-- End of preheader -->
				<!-- Start of header -->
				<!-- End of Header -->
				<!-- Start of main-banner -->
				<!-- End of main-banner -->
				<!-- Start Full Text -->
				<!-- end of full text -->
				<!-- Start of separator -->
				<!-- End of separator -->
				<!-- 3 Start of Columns -->
				<!-- end of 3 Columns -->
				<!-- Start of separator -->
				<!-- End of separator -->
				<!-- 2columns -->
				<!-- end of 2 columns -->
				<!-- Start of separator -->
				<!-- End of separator -->
				<!-- Start Full Text -->
				<!-- end of full text -->
				<!-- Start of separator -->
				<!-- End of separator -->
				<!-- Start of Postfooter -->
				<!-- End of postfooter -->
				<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="full-text">
					<tbody>
						<tr>
							<td>
								<table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth" hasbackground="true">
									<tbody>
										<tr>
											<td width="100%">
												<table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
													<tbody>
														<!-- Spacing -->
														<tr>
															<td height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
															</td>
														</tr>
														<!-- Spacing -->
														<tr>
															<td>
																<table width="560" align="center" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner">
																	<tbody>
																		<!-- Title -->
																		<tr>
																			<td style="font-family: Helvetica, arial, sans-serif; font-size: 30px; color: #333333; text-align:center; line-height: 30px;" st-title="fulltext-heading">
																				<p>
																					Porthmadog Tide Times
																				</p>
																			</td>
																		</tr>
																		<!-- End of Title --><!-- spacing -->
																		<tr>
																			<td width="100%" height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
																			</td>
																		</tr>
																		<!-- End of spacing --><!-- content -->
																		<tr>
																			<td style="font-family: Helvetica, arial, sans-serif; font-size: 16px; color: #666666; text-align:center; line-height: 30px;" st-content="fulltext-content">
																				<p>
																					Greetings from Porthmadog!
																				</p>
																				<p>
																					Below are the times and heights of high water at Porthmadog for next week.
																				</p>
																			</td>
																		</tr>
																		<!-- End of content -->
																	</tbody>
																</table>
															</td>
														</tr>
														<!-- Spacing -->
														<tr>
															<td height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
															</td>
														</tr>
														<!-- Spacing -->
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
				<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="separator">
					<tbody>
						<tr>
							<td>
								<table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth" hasbackground="true">
									<tbody>
										<tr>
											<td align="center" height="30" style="font-size:1px; line-height:1px;">
											</td>
										</tr>
										<tr>
											<td width="550" align="center" height="1" bgcolor="#d1d1d1" style="font-size:1px; line-height:1px;">
											</td>
										</tr>
										<tr>
											<td align="center" height="30" style="font-size:1px; line-height:1px;">
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
				<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="3-images+text-columns">
					<tbody>
						<tr>
							<td>
								<table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth" hasbackground="true">
									<tbody>
										<tr>
											<td width="100%">
												<table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
													<tbody>
														<tr>
															<td>
																<!-- col 1 -->
																<table width="186" align="left" border="0" cellpadding="0" cellspacing="0" class="devicewidth">
																	<tbody>
																		<!-- image 2 -->
																		
																		<!-- end of image2 -->
																		<tr>
																			<td>
																				<!-- start of text content table -->
																				<table width="186" align="center" border="0" cellpadding="0" cellspacing="0" class="devicewidthinner">
																					<tbody>
																						<!-- Spacing -->
																						<tr>
																							<td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
																							</td>
																						</tr>
																						<!-- Spacing --><!-- title2 -->
																						<tr>
																							<td style="font-family: Helvetica, arial, sans-serif; font-size: 18px; color: #666666; text-align:center; line-height: 24px;" st-title="3col-title1">
																								<p>' . date("l j<\s\u\p>S</\s\u\p>  M", strtotime($startdate)) . '</p>
																							</td>
																						</tr>
																						<!-- end of title2 --><!-- Spacing -->
																						<tr>
																							<td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
																							</td>
																						</tr>
																						<!-- Spacing --><!-- content2 -->
																						<tr>
																							<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #889098; text-align:center; line-height: 24px;" st-content="3col-content1">
																								<p>
<center><table border="0">
  <tbody><tr>
    <td><p>' . $tides[0][1] . '</p></td>
    <td><p>(' . $tides[0][3] . ')</p></td>
  </tr>
  <tr>
    <td><p>' . $tides[0][2] . '</p></td>
    <td><p>(' . $tides[0][4] . ')</p></td>
  </tr>
</tbody></table></center>
</p>
																							</td>
																						</tr>
																						<!-- end of content2 --><!-- Spacing -->
																						<tr>
																							<td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
																							</td>
																						</tr>
																						<!-- Spacing --><!-- read more -->
																						
																						<!-- end of read more -->
																					</tbody>
																				</table>
																			</td>
																		</tr>
																		<!-- end of text content table -->
																	</tbody>
																</table>
																<!-- spacing -->
																<table width="20" align="left" border="0" cellpadding="0" cellspacing="0" class="removeMobile">
																	<tbody>
																		<tr>
																			<td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
																			</td>
																		</tr>
																	</tbody>
																</table>
																<!-- end of spacing --><!-- col 2 -->
																<table width="186" align="left" border="0" cellpadding="0" cellspacing="0" class="devicewidth">
																	<tbody>
																		<!-- image 2 -->
																		
																		<!-- end of image2 -->
																		<tr>
																			<td>
																				<!-- start of text content table -->
																				<table width="186" align="center" border="0" cellpadding="0" cellspacing="0" class="devicewidthinner">
																					<tbody>
																						<!-- Spacing -->
																						<tr>
																							<td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
																							</td>
																						</tr>
																						<!-- Spacing --><!-- title2 -->
																						<tr>
																							<td style="font-family: Helvetica, arial, sans-serif; font-size: 18px; color: #666666; text-align:center; line-height: 24px;" st-title="3col-title2">
																								<p>' . date("l j<\s\u\p>S</\s\u\p>  M", strtotime($startdate) + (86400)) . '</p>
																							</td>
																						</tr>
																						<!-- end of title2 --><!-- Spacing -->
																						<tr>
																							<td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
																							</td>
																						</tr>
																						<!-- Spacing --><!-- content2 -->
																						<tr>
																							<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #889098; text-align:center; line-height: 24px;" st-content="3col-content2">
																								<p></p><p>
</p><center><table border="0">
  <tbody><tr>
    <td><p>' . $tides[1][1] . '</p></td>
    <td><p>(' . $tides[1][3] . ')</p></td>
  </tr>
  <tr>
    <td><p>' . $tides[1][2] . '</p></td>
    <td><p>(' . $tides[1][4] . ')</p></td>
  </tr>
</tbody></table></center>
<p></p>						<p></p>
																							</td>
																						</tr>
																						<!-- end of content2 --><!-- Spacing -->
																						<tr>
																							<td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
																							</td>
																						</tr>
																						<!-- /Spacing --><!-- read more -->
																						
																						<!-- end of read more -->
																					</tbody>
																				</table>
																			</td>
																		</tr>
																		<!-- end of text content table -->
																	</tbody>
																</table>
																<!-- end of col 2 --><!-- spacing -->
																<table width="1" align="left" border="0" cellpadding="0" cellspacing="0" class="removeMobile">
																	<tbody>
																		<tr>
																			<td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
																			</td>
																		</tr>
																	</tbody>
																</table>
																<!-- end of spacing --><!-- col 3 -->
																<table width="186" align="right" border="0" cellpadding="0" cellspacing="0" class="devicewidth">
																	<tbody>
																		<!-- image3 -->
																		
																		<!-- end of image3 -->
																		<tr>
																			<td>
																				<!-- start of text content table -->
																				<table width="186" align="center" border="0" cellpadding="0" cellspacing="0" class="devicewidthinner">
																					<tbody>
																						<!-- Spacing -->
																						<tr>
																							<td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
																							</td>
																						</tr>
																						<!-- Spacing --><!-- title -->
																						<tr>
																							<td style="font-family: Helvetica, arial, sans-serif; font-size: 18px; color: #666666; text-align:center; line-height: 24px;" st-title="3col-title3">
																								<p>' . date("l j<\s\u\p>S</\s\u\p>  M", strtotime($startdate) + (86400*2)) . '</p>
																							</td>
																						</tr>
																						<!-- end of title --><!-- Spacing -->
																						<tr>
																							<td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
																							</td>
																						</tr>
																						<!-- Spacing --><!-- content -->
																						<tr>
																							<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #889098; text-align:center; line-height: 24px;" st-content="3col-content3">
																								<p>
</p><center><table border="0">
  <tbody><tr>
    <td><p>' . $tides[2][1] . '</p></td>
    <td><p>(' . $tides[2][3] . ')</p></td>
  </tr>
  <tr>
    <td><p>' . $tides[2][2] . '</p></td>
    <td><p>(' . $tides[2][4] . ')</p></td>
  </tr>
</tbody></table></center>
<p></p>
																							</td>
																						</tr>
																						<!-- end of content --><!-- Spacing -->
																						<tr>
																							<td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
																							</td>
																						</tr>
																						<!-- Spacing --><!-- read more -->
																						
																						<!-- end of read more -->
																					</tbody>
																				</table>
																			</td>
																		</tr>
																		<!-- end of text content table -->
																	</tbody>
																</table>
															</td>
															<!-- spacing -->
															<!-- end of spacing -->
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
				<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="3-images+text-columns">
					<tbody>
						<tr>
							<td>
								<table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth" hasbackground="true">
									<tbody>
										<tr>
											<td width="100%">
												<table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
													<tbody>
														<tr>
															<td>
																<!-- col 1 -->
																<table width="186" align="left" border="0" cellpadding="0" cellspacing="0" class="devicewidth">
																	<tbody>
																		<tr>
																			<td>
																				<!-- start of text content table -->
																				<table width="186" align="center" border="0" cellpadding="0" cellspacing="0" class="devicewidthinner">
																					<tbody>
																						<!-- Spacing -->
																						<tr>
																							<td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
																							</td>
																						</tr>
																						<!-- Spacing --><!-- title2 -->
																						<tr>
																							<td style="font-family: Helvetica, arial, sans-serif; font-size: 18px; color: #666666; text-align:center; line-height: 24px;" st-title="3col-title1">
																								<p>' . date("l j<\s\u\p>S</\s\u\p>  M", strtotime($startdate) + (86400*3)) . '</p>
																							</td>
																						</tr>
																						<!-- end of title2 --><!-- Spacing -->
																						<tr>
																							<td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
																							</td>
																						</tr>
																						<!-- Spacing --><!-- content2 -->
																						<tr>
																							<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #889098; text-align:center; line-height: 24px;" st-content="3col-content1">
																								<p>
</p><center><table border="0">
  <tbody><tr>
    <td><p>' . $tides[3][1] . '</p></td>
    <td><p>(' . $tides[3][3] . ')</p></td>
  </tr>
  <tr>
    <td><p>' . $tides[3][2] . '</p></td>
    <td><p>(' . $tides[3][4] . ')</p></td>
  </tr>
</tbody></table></center>
<p></p>
																							</td>
																						</tr>
																						<!-- end of content2 --><!-- Spacing -->
																						<tr>
																							<td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
																							</td>
																						</tr>
																						<!-- Spacing --><!-- read more -->
																						
																						<!-- end of read more -->
																					</tbody>
																				</table>
																			</td>
																		</tr>
																		<!-- end of text content table -->
																	</tbody>
																</table>
																<!-- spacing -->
																<table width="20" align="left" border="0" cellpadding="0" cellspacing="0" class="removeMobile">
																	<tbody>
																		<tr>
																			<td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
																			</td>
																		</tr>
																	</tbody>
																</table>
																<!-- end of spacing --><!-- col 2 -->
																<table width="186" align="left" border="0" cellpadding="0" cellspacing="0" class="devicewidth">
																	<tbody>
																		<!-- image 2 -->
																		
																		<!-- end of image2 -->
																		<tr>
																			<td>
																				<!-- start of text content table -->
																				<table width="186" align="center" border="0" cellpadding="0" cellspacing="0" class="devicewidthinner">
																					<tbody>
																						<!-- Spacing -->
																						<tr>
																							<td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
																							</td>
																						</tr>
																						<!-- Spacing --><!-- title2 -->
																						<tr>
																							<td style="font-family: Helvetica, arial, sans-serif; font-size: 18px; color: #666666; text-align:center; line-height: 24px;" st-title="3col-title2">
																								<p>' . date("l j<\s\u\p>S</\s\u\p>  M", strtotime($startdate) + (86400*4)) . '</p>
																							</td>
																						</tr>
																						<!-- end of title2 --><!-- Spacing -->
																						<tr>
																							<td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
																							</td>
																						</tr>
																						<!-- Spacing --><!-- content2 -->
																						<tr>
																							<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #889098; text-align:center; line-height: 24px;" st-content="3col-content2">
																								<p>
</p><center><table border="0">
  <tbody><tr>
    <td><p>' . $tides[4][1] . '</p></td>
    <td><p>(' . $tides[4][3] . ')</p></td>
  </tr>
  <tr>
    <td><p>' . $tides[4][2] . '</p></td>
    <td><p>(' . $tides[4][4] . ')</p></td>
  </tr>
</tbody></table></center>
<p></p>
																							</td>
																						</tr>
																						<!-- end of content2 --><!-- Spacing -->
																						<tr>
																							<td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
																							</td>
																						</tr>
																						<!-- /Spacing --><!-- read more -->
																						
																						<!-- end of read more -->
																					</tbody>
																				</table>
																			</td>
																		</tr>
																		<!-- end of text content table -->
																	</tbody>
																</table>
																<!-- end of col 2 --><!-- spacing -->
																<table width="1" align="left" border="0" cellpadding="0" cellspacing="0" class="removeMobile">
																	<tbody>
																		<tr>
																			<td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
																			</td>
																		</tr>
																	</tbody>
																</table>
																<!-- end of spacing --><!-- col 3 -->
																<table width="186" align="right" border="0" cellpadding="0" cellspacing="0" class="devicewidth">
																	<tbody>
																		<!-- image3 -->
																		
																		<!-- end of image3 -->
																		<tr>
																			<td>
																				<!-- start of text content table -->
																				<table width="186" align="center" border="0" cellpadding="0" cellspacing="0" class="devicewidthinner">
																					<tbody>
																						<!-- Spacing -->
																						<tr>
																							<td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
																							</td>
																						</tr>
																						<!-- Spacing --><!-- title -->
																						<tr>
																							<td style="font-family: Helvetica, arial, sans-serif; font-size: 18px; color: #666666; text-align:center; line-height: 24px;" st-title="3col-title3">
																								<p>' . date("l j<\s\u\p>S</\s\u\p>  M", strtotime($startdate) + (86400*5)) . '<p>
<p></p>																						</td>
																						</tr>
																						<!-- end of title --><!-- Spacing -->
																						<tr>
																							<td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
																							</td>
																						</tr>
																						<!-- Spacing --><!-- content -->
																						<tr>
																							<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #889098; text-align:center; line-height: 24px;" st-content="3col-content3">
																								<p>
</p><center><table border="0">
  <tbody><tr>
    <td><p>' . $tides[5][1] . '</p></td>
    <td><p>(' . $tides[5][3] . ')</p></td>
  </tr>
  <tr>
    <td><p>' . $tides[5][2] . '</p></td>
    <td><p>(' . $tides[5][4] . ')</p></td>
  </tr>
</tbody></table></center>
<p></p>
																							</td>
																						</tr>
																						<!-- end of content --><!-- Spacing -->
																						<tr>
																							<td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
																							</td>
																						</tr>
																						<!-- Spacing --><!-- read more -->
																						
																						<!-- end of read more -->
																					</tbody>
																				</table>
																			</td>
																		</tr>
																		<!-- end of text content table -->
																	</tbody>
																</table>
															</td>
															<!-- spacing -->
															<!-- end of spacing -->
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="3-images+text-columns">
					<tbody>
						<tr>
							<td>
								<table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth" hasbackground="true">
									<tbody>
										<tr>
											<td width="100%">
												<table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
													<tbody>
														<tr>
															<td>
																<!-- col 1 -->
																<table width="186" align="left" border="0" cellpadding="0" cellspacing="0" class="devicewidth">
																	<tbody>
																		<tr>
																			<td>
																				<!-- start of text content table -->
																				<table width="186" align="center" border="0" cellpadding="0" cellspacing="0" class="devicewidthinner">
																					<tbody>
																						<!-- Spacing -->
																						<tr>
																							<td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
																							</td>
																						</tr>
																						<!-- Spacing --><!-- title2 -->
																						<tr>
																							<td style="font-family: Helvetica, arial, sans-serif; font-size: 18px; color: #666666; text-align:center; line-height: 24px;" st-title="3col-title1">
																								<p>' . date("l j<\s\u\p>S</\s\u\p>  M", strtotime($startdate) + (86400*6)) . '</p>
																							</td>
																						</tr>
																						<!-- end of title2 --><!-- Spacing -->
																						<tr>
																							<td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
																							</td>
																						</tr>
																						<!-- Spacing --><!-- content2 -->
																						<tr>
																							<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #889098; text-align:center; line-height: 24px;" st-content="3col-content1">
																								<p>
</p><center><table border="0">
  <tbody><tr>
    <td><p>' . $tides[6][1] . '</p></td>
    <td><p>(' . $tides[6][3] . ')</p></td>
  </tr>
  <tr>
    <td><p>' . $tides[6][2] . '</p></td>
    <td><p>(' . $tides[6][4] . ')</p></td>
  </tr>
</tbody></table></center>
<p></p>
																							</td>
																						</tr>
																						<!-- end of content2 --><!-- Spacing -->
																						<tr>
																							<td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
																							</td>
																						</tr>
																						<!-- Spacing --><!-- read more -->
																						
																						<!-- end of read more -->
																					</tbody>
																				</table>
																			</td>
																		</tr>
																		<!-- end of text content table -->
																	</tbody>
																</table>
																<!-- spacing -->
																<table width="20" align="left" border="0" cellpadding="0" cellspacing="0" class="removeMobile">
																	<tbody>
																		<tr>
																			<td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
																			</td>
																		</tr>
																	</tbody>
																</table>
																<!-- end of spacing --><!-- col 2 -->
																<table width="186" align="left" border="0" cellpadding="0" cellspacing="0" class="devicewidth">
																	<tbody>
																		<!-- image 2 -->
																		
																		<!-- end of image2 -->
																		<tr>
																			<td>
																				<!-- start of text content table -->
																				<table width="186" align="center" border="0" cellpadding="0" cellspacing="0" class="devicewidthinner">
																					<tbody>
																						<!-- Spacing -->
																						<tr>
																							<td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
																							</td>
																						</tr>
																						<!-- Spacing --><!-- title2 -->
																						<tr>
																							<td style="font-family: Helvetica, arial, sans-serif; font-size: 18px; color: #666666; text-align:center; line-height: 24px;" st-title="3col-title2">
																								<p>' . date("l j<\s\u\p>S</\s\u\p>  M", strtotime($startdate) + (86400*7)) . '</p>
																							</td>
																						</tr>
																						<!-- end of title2 --><!-- Spacing -->
																						<tr>
																							<td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
																							</td>
																						</tr>
																						<!-- Spacing --><!-- content2 -->
																						<tr>
																							<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #889098; text-align:center; line-height: 24px;" st-content="3col-content2">
																								<p>
</p><center><table border="0">
  <tbody><tr>
    <td><p>' . $tides[7][1] . '</p></td>
    <td><p>(' . $tides[7][3] . ')</p></td>
  </tr>
  <tr>
    <td><p>' . $tides[7][2] . '</p></td>
    <td><p>(' . $tides[7][4] . ')</p></td>
  </tr>
</tbody></table></center>
<p></p>
																							</td>
																						</tr>
																						<!-- end of content2 --><!-- Spacing -->
																						<tr>
																							<td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
																							</td>
																						</tr>
																						<!-- /Spacing --><!-- read more -->
																						
																						<!-- end of read more -->
																					</tbody>
																				</table>
																			</td>
																		</tr>
																		<!-- end of text content table -->
																	</tbody>
																</table>
																<!-- end of col 2 --><!-- spacing -->
																<table width="1" align="left" border="0" cellpadding="0" cellspacing="0" class="removeMobile">
																	<tbody>
																		<tr>
																			<td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
																			</td>
																		</tr>
																	</tbody>
																</table>
																<!-- end of spacing --><!-- col 3 -->
																<table width="186" align="right" border="0" cellpadding="0" cellspacing="0" class="devicewidth">
																	<tbody>
																		<!-- image3 -->
																		
																		<!-- end of image3 -->
																		<tr>
																			<td>
																				<!-- start of text content table -->
																				<table width="186" align="center" border="0" cellpadding="0" cellspacing="0" class="devicewidthinner">
																					<tbody>
																						<!-- Spacing -->
																						<tr>
																							<td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
																							</td>
																						</tr>
																						<!-- Spacing --><!-- title -->
																						<tr>
																							<td style="font-family: Helvetica, arial, sans-serif; font-size: 18px; color: #666666; text-align:center; line-height: 24px;" st-title="3col-title3">
																								<p>' . date("l j<\s\u\p>S</\s\u\p>  M", strtotime($startdate) + (86400*8)) . '</p>
																						</td>
																						</tr>
																						<!-- end of title --><!-- Spacing -->
																						<tr>
																							<td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
																							</td>
																						</tr>
																						<!-- Spacing --><!-- content -->
																						<tr>
																							<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #889098; text-align:center; line-height: 24px;" st-content="3col-content3">
																								<p>
</p><center><table border="0">
  <tbody><tr>
    <td><p>' . $tides[8][1] . '</p></td>
    <td><p>(' . $tides[8][3] . ')</p></td>
  </tr>
  <tr>
    <td><p>' . $tides[8][2] . '</p></td>
    <td><p>(' . $tides[8][4] . ')</p></td>
  </tr>
</tbody></table></center>
<p></p>
																							</td>
																						</tr>
																						<!-- end of content --><!-- Spacing -->
																						<tr>
																							<td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
																							</td>
																						</tr>
																						<!-- Spacing --><!-- read more -->
																						
																						<!-- end of read more -->
																					</tbody>
																				</table>
																			</td>
																		</tr>
																		<!-- end of text content table -->
																	</tbody>
																</table>
															</td>
															<!-- spacing -->
															<!-- end of spacing -->
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
				<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="separator">
					<tbody>
						<tr>
							<td>
								<table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth" hasbackground="true">
									<tbody>
										<tr>
											<td align="center" height="30" style="font-size:1px; line-height:1px;">
											</td>
										</tr>
										<tr>
											<td width="550" align="center" height="1" bgcolor="#d1d1d1" style="font-size:1px; line-height:1px;">
											</td>
										</tr>
										<tr>
											<td align="center" height="30" style="font-size:1px; line-height:1px;">
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
				<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="full-text">
					<tbody>
						<tr>
							<td>
								<table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth" hasbackground="true">
									<tbody>
										<tr>
											<td width="100%">
												<table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
													<tbody>
														<!-- Spacing -->
														<tr>
															<td height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
															</td>
														</tr>
														<!-- Spacing -->
														<tr>
															<td>
																<table width="560" align="center" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner">
																	<tbody>
																		<!-- Title -->
																		<tr>
																			<td style="font-family: Helvetica, arial, sans-serif; font-size: 30px; color: #333333; text-align:center; line-height: 30px;" st-title="fulltext-heading">
																				<p>
																					Have a Great Week!
																				</p>
																			</td>
																		</tr>
																		<!-- End of Title --><!-- spacing -->
																		<tr>
																			<td width="100%" height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
																			</td>
																		</tr>
																		<!-- End of spacing --><!-- content -->
																		<tr>
																			<td style="font-family: Helvetica, arial, sans-serif; font-size: 16px; color: #666666; text-align:center; line-height: 30px;" st-content="fulltext-content">
																				<p style="text-align: right;">
																					<em>The Port-Tides.com Team</em>
																				</p>
																			</td>
																		</tr>
																		<!-- End of content -->
																	</tbody>
																</table>
															</td>
														</tr>
														<!-- Spacing -->
														<tr>
															<td height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
															</td>
														</tr>
														<!-- Spacing -->
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
				<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="separator">
					<tbody>
						<tr>
							<td>
								<table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth" hasbackground="true">
									<tbody>
										<tr>
											<td align="center" height="30" style="font-size:1px; line-height:1px;">
											</td>
										</tr>
										<tr>
											<td width="550" align="center" height="1" bgcolor="#d1d1d1" style="font-size:1px; line-height:1px;">
											</td>
										</tr>
										<tr>
											<td align="center" height="30" style="font-size:1px; line-height:1px;">
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
				<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="footer">
					<tbody>
						<tr>
							<td>
								<table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth" hasbackground="true">
									<tbody>
										<tr>
											<td width="100%">
												<table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
													<tbody>
														<tr>
															<td align="center" valign="middle" style="font-family: Helvetica, arial, sans-serif; font-size: 14px;color: #666666" st-content="postfooter">
																<p>
																	This E-Mail was sent to you because you subscribe to the <a href="http://www.port-tides.com">Port-Tides.com</a> weekly tidal predictions service. If you would no longer like to recieve these E-Mails you can <a style="color: rgb(10, 140, 206);" href="#">Unsubscribe</a>
																</p>
															</td>
														</tr>
														<!-- Spacing -->
														<tr>
															<td width="100%" height="20">
															</td>
														</tr>
														<!-- Spacing -->
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			
		</body></html>';
	return $html;
}
function weeklyemail($to_email, $to_name = null, $weekbeginning) {
	global $db_hostname, $db_username, $db_password, $db_database;
	$conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
	// Check connection
	if ($conn->connect_error) {
		 die("Connection failed, please contact support");
	} 


	$data = array(	'api_user' => 'port_tides',
					'api_key' => 'P0R56TH34MADOG!!',
					'to' => $to_email,
					'subject' => 'Porthmadog Tide Times for week beginning ' . date("l M Y", strtotime($weekbeginning)),
					'html' => $html,
					'from' => 'tides@port-tides.com',
					'fromname' => 'Porthmadog Tide Times'
				);
	if ($to_name != null) $data += ['toname' => $to_name];
	$options = array(
		'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			'content' => http_build_query($data),
		),
	);
	$context  = stream_context_create($options);
	$result = file_get_contents("https://api.sendgrid.com/api/mail.send.json", false, $context);
	return;
}
//echo weeklyemail('James@bithell.com', $to_name = null, 20150726);
echo returnhtml(date("Y-m-d"));
?>