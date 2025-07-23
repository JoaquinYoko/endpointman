<?php
global $active_modules;

if (!empty($active_modules['endpoint']['rawname'])) {
	if (FreePBX::Endpointman()->configmod->get("disable_endpoint_warning") !== "1") {
		include('page.epm_warning.php');
	}
}
?>

<head>
	<style>
		/* Cible uniquement les éléments dans la section "container" */
		.container {
			text-align: center;
		}

		.container h1 {
			color: #2e7d32;
		}

		.container .button {
			display: inline-block;
			margin: 10px;
			padding: 15px 25px;
			font-size: 16px;
			font-weight: bold;
			color: #ffffff;
			background-color: #4caf50;
			border: none;
			border-radius: 5px;
			cursor: pointer;
			transition: background-color 0.3s ease, transform 0.2s ease;
			text-decoration: none;
		}

		.container .button:hover {
			background-color: #388e3c;
			transform: scale(1.1);
		}

		.container .button:active {
			background-color: #1b5e20;
		}

		/* Ajout d'un style par défaut pour le reste du contenu */
		.content {
			padding: 20px;
		}
	</style>

</head>

<body>
	<div class="container">
		<h1>Welcome on OSS EndPoint Manager</h1>
		<a href="?display=epm_advanced" class="button">Settings</a>
		<a href="?display=epm_devices" class="button">Extension Mapping</a>
		<a href="?display=epm_config" class="button">Package Manager</a>
		<a href="?display=epm_templates" class="button">Template Manager</a>
		<a href="?display=epm_placeholders" class="button">Config Placeholders</a>
	</div>



	<h3>Fork Project : <a href="https://github.com/AlexKientz/freepbx-endpointmanager">GitHub Links</a></h3>
	<h3>Open Source Information</h3>

	<p>OSS PBX End Point Manager is the community supported PBX Endpoint Manager for FreePBX.<br>The front end WebUI is
		hosted at: <a href="https://github.com/FreePBX/endpointman" class="external-link"
			rel="nofollow">https://github.com/FreePBX/endpointman</a><br>The back end configurator is hosted at: <a
			href="https://github.com/provisioner/Provisioner" class="external-link"
			rel="nofollow">https://github.com/provisioner/Provisioner</a><br>Pull Requests can be made to either of
		these and are encouraged.</p>

	<div><span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"> </span>
		<div class="confluence-information-macro-body">
			<p>This is not the same at the commercial EPM and It is <strong>NOT</strong> supported by FreePBX or Sangoma
				Technologies inc. If you are looking for a Commercially supported endpoint manager please look into the
				Commercial Endpoint Manager by <span>Sangoma Technologies inc</span></p>
		</div>
	</div>

	<br>
</body>