<?php

	require_once("configuration/main.php");

	if(!$_SESSION['accountid'])
	{
		redirect("login");
	}

	if($_GET['remove'])
	{
		$mQuery = $mysql->query("SELECT `path` FROM `files` WHERE `user` = '" . $_SESSION['accountid'] . "' AND `fileid` = '" . escape($_GET['remove']) . "'");

		if($mQuery->num_rows)
		{
			$mData = $mQuery->fetch_assoc();

			$mysql->query("DELETE FROM `files` WHERE `user` = '" . $_SESSION['accountid'] . "' AND `fileid` = '" . escape($_GET['remove']) . "'");

			unlink($mData['path']);

			errorNotice("The file has been removed.");
			redirect("index", 2);
		}
		else
		{
			redirect("index");
		}
	}

?>

<h1 class='pageHeading'>
	<table cellpadding='0' cellspacing='0' width='95%'>
		<tr>
			<td>
				My Files
			</td>

			<td align='right'>
				<button id='uploadFiles' class='basicButton'>
					Upload
				</button>
			</td>
		</tr>
	</table>
</h1>

<?php

	$mQuery = $mysql->query("SELECT * FROM `files` WHERE `user` = '" . $_SESSION['accountid'] . "'");

	while($mData = $mQuery->fetch_assoc())
	{
		$fileExtension = pathinfo($mData['name'], PATHINFO_EXTENSION);
		$fileIcon = (file_exists("images/files/" . $fileExtension . ".png")) ? "images/files/" . $fileExtension . ".png" : "images/files/default.png";

		echo
		"<a href='download?" . $mData['fileid'] . "' class='fileDownload'>
			<div data-file='" . $mData['fileid'] . "' class='fileContainer'>
				<img src='$fileIcon'>

				<div class='fileContainerTitle'>
					" . $mData['name'] . "
				</div>

				<div class='fileContainerOptions'>
					<a data-file='" . $mData['name'] . "' class='renameFile'></a>
					<a href='?remove=" . $mData['fileid'] . "'></a>
				</div>
			</div>
		</a>";
	}

?>

<script>
	$(document).ready(function()
	{
		var uniqueID = Math.random(), nextFileList = 1, fileSize = "", editingFile = "";

		function calculateFileSize(bytes)
		{
			if(bytes >= 1073741824) return Math.round(bytes / 1073741824) + "GB";
			else if(bytes >= 1048576) return Math.round(bytes / 1048576) + "MB";
			else if(bytes >= 1024) return Math.round(bytes / 1024) + "KB";
			else return bytes + "B";
		}
		
		function openUploader()
		{
			$('#wrapper').append("<div id='uploaderCover' align='center' class='hidden'> \
				<form id='uploaderFiles' action='upload' method='POST' enctype='multipart/form-data'> \
					<input type='hidden' name='MAX_FILE_SIZE' value='2147483647'> \
					<input type='hidden' id='uploaderIgnore' name='ignore'> \
				</form> \
				\
				<div class='uploaderContainer'> \
					<div class='uploaderTitle'> \
						<table width='100%' cellpadding='0' cellspacing='0'> \
							<tr> \
								<td> \
									File Uploader \
								</td> \
								\
								<td align='right'> \
									<div id='uploaderClose'> \
										 \
									</div> \
								</td> \
							</tr> \
						</table> \
					</div> \
					\
					<div id='uploaderMain'> \
					</div> \
					\
					<div id='uploaderControls'> \
						<table width='100%'> \
							<tr> \
								<td id='uploaderAdd'> \
									 \
								</td> \
								\
								<td id='uploaderInfo' class='hidden'> \
									<span id='uploaderInfoFiles'>0</span> files, <span id='uploaderInfoSize' data-size='0'></span> \
								</td> \
								\
								<td align='right'> \
									<button id='uploaderBegin'> \
										Begin Upload \
									</button> \
								</td> \
							</tr> \
						</table> \
					</div> \
				</div> \
			</div>");

			$('#uploaderCover').fadeIn(500);

			$('#uploaderAdd').click(function()
			{
				$('#uploaderFiles').append("<input type='file' id='upload-list-" + nextFileList + "' name='upload-list-" + nextFileList + "[]' class='hidden' multiple>");
				$('#upload-list-' + nextFileList + '').trigger("click");

				$('#upload-list-' + nextFileList + '').change(function()
				{
					$('#uploaderInfo').show();

					for(var fileIndex = 0; fileIndex < this.files.length; fileIndex++)
					{
						$('#uploaderMain').append("<div id='" + this.files[fileIndex].name + "' class='uploaderFile'> \
							<div class='uploaderFileName'> \
								" + this.files[fileIndex].name + " \
							</div> \
							\
							<div class='uploaderFileSize'> \
								" + calculateFileSize(this.files[fileIndex].size) + " \
							</div> \
							\
							<div class='uploaderFileOptions'> \
								<div data-file='" + this.files[fileIndex].name + "' class='uploaderRemove'>Remove</div> \
							</div> \
						</div>");

						$('.uploaderRemove').unbind("click").click(function()
						{
							$('#uploaderIgnore').val($('#uploaderIgnore').val() + $(this).data("file") + "|");
							$(this).parent().parent().parent().parent().parent().remove();
						});

						$('#uploaderIgnore').val($('#uploaderIgnore').val().replace(this.files[fileIndex].name + "|", ""));

						$('#uploaderInfoFiles').text(parseInt($('#uploaderInfoFiles').text()) + 1);
						$('#uploaderInfoSize').data("size", parseInt($('#uploaderInfoSize').data("size")) + this.files[fileIndex].size).text(calculateFileSize($('#uploaderInfoSize').data("size")));
					}
				});

				nextFileList++;
			});

			$('#uploaderBegin').click(function()
			{
				$('#uploaderAdd, #uploaderBegin, #uploaderInfo').hide();

				$('#uploaderControls').append("<div id='uploaderProgressOuter'> \
					<div id='uploaderProgressInner'> \
						<div id='uploaderProgress'>0%</div> \
					</div> \
				</div>");

				$('#uploaderFiles').ajaxForm(
				{
					uploadProgress: function(event, position, total, percentComplete)
					{
						$('#uploaderProgress').text(percentComplete + "%");
						$('#uploaderProgressInner').width(percentComplete + "%");
					},
					complete: function(xhr)
					{
						var currentElement = 0;

						$('.uploaderRemove').each(function()
						{
							currentElement = this;

							$(this).removeClass("uploaderRemove").unbind("click").addClass("uploaderCopy").text("Copy Link");

							$.post("getlink.php", {user: <?php echo $_SESSION['accountid']; ?>, file: $(this).data("file")}, function(data)
							{
								$(currentElement).zclip(
								{
									path: "js/ZeroClipboard.swf",
									copy: window.location.href.substring(0, window.location.href.lastIndexOf('/')) + "/download?" + data,
									afterCopy: function()
									{
										
									}
								})
							});
						});

						$('#uploaderProgress').text("Upload successful");
					}
				}).submit();
			});

			$('#uploaderClose').click(function()
			{
				$('#uploaderCover').fadeOut(500, function()
				{
					$(this).remove();
				});
			});
		}

		$('#uploadFiles').click(function()
		{
			openUploader();
		});

		$('.fileDownload').click(function()
		{
			if($('#editFile').is(":visible"))
			{
				return false;
			}
		});

		$('.renameFile').click(function()
		{
			if(!$('#editFile').is(":visible"))
			{
				$(this).parent().parent().find(".fileContainerTitle").html("<input type='text' id='editFile' value='" + $(this).parent().parent().find(".fileContainerTitle").text().trim() + "'>").css("color", "black");

				editingFile = $(this).parent().parent().data("file");

				$('#editFile').focus().keyup(function(event)
				{
					if(event.keyCode == 13)
					{
						$.post("editfile.php", {fileid: editingFile, name: $(this).val()});

						$(this).parent().parent().find(".fileContainerTitle").text($(this).val()).css("color", "white");
					}
				});
			}
		});
	});
</script>