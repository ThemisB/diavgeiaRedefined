Dim fso,fso_files
Dim srcFiles(),tarFiles()
Dim FilesCnt

Set fso = CreateObject("Scripting.FileSystemObject")

'Get Files
Function GetFiles(ByVal path,ByVal exclude)
	Dim folder
	fso_files = Array()
	If CheckFolder(path) Then
		Set folder=fso.GetFolder(path)
		Call fso_LoadFiles(folder,exclude)
	End If
	getFiles = Join(fso_files,";")
End Function
Function fso_LoadFiles(folder,exclude)
	Dim f,cnt
	cnt=UBound(fso_files)
	If cnt<0 Then cnt=0
	ReDim Preserve fso_files(cnt+folder.Files.Count)
	For Each f in folder.Files
		fso_files(cnt)=f.Path
		cnt=cnt+1
	Next
	'search subfolders
	For Each f in folder.SubFolders
		If InStr(1,","& exclude &",",","& f.name &",")=0 Then
			Call fso_LoadFiles(f,exclude)
		End If
	Next
End Function

Function BuildFileSturcure(ByVal srcPath,ByVal tarPath,ByVal exclude)
	'Reset srcFiles(),tarFiles
	ReDim srcFiles(0)
	ReDim tarFiles(0)
	FilesCnt=-1
	Call CopyFolderStructure(srcPath,tarPath,exclude)
End Function

'CopyFiles
Function CopyFiles(ByVal srcPath,ByVal tarPath)
	Dim f,srcFolder
	
	'Append \ to tarPath
	If Right(tarPath,1)<>"\" Then tarPath=tarPath+"\"
	
	Set srcFolder=fso.GetFolder(srcPath)
	For Each f in srcFolder.Files
		state=jsCheckFileState(f.name,f.path)
		If (state=1) Then
			'files to be compressed
			FilesCnt=FilesCnt+1
			ReDim Preserve srcFiles(FilesCnt)
			ReDim Preserve tarFiles(FilesCnt)
			srcFiles(FilesCnt)=f.path
			tarFiles(FilesCnt)=fso.BuildPath(tarPath,f.name)
		ElseIf (state=2) Then
			'Copy file
			Call fso.CopyFile(f.Path,tarPath)
		End If
	Next
End Function

'Copy Folder Structure - calls jsCheckFileState()
Function CopyFolderStructure(ByVal srcPath,ByVal tarPath,ByVal exclude)
	Dim nsp,ntp,folder,srcFolder
		
	If CheckFolder(srcPath) And CheckFolder(tarPath) Then
		Call CopyFiles(srcPath,tarPath)
		Set srcFolder=fso.GetFolder(srcPath)
		For Each folder in srcFolder.SubFolders
			If InStr(1,","& exclude &",",","& folder.name &",")=0 Then
				nsp=fso.BuildPath(srcPath,folder.name)
				ntp=fso.BuildPath(tarPath,folder.name)
				if Not CheckFolder(ntp) Then fso.CreateFolder(ntp)
				Call CopyFolderStructure(nsp,ntp,exclude)
			End If
		Next
	End If
End Function

'Get Source file to be compress
Function GetSRCFile(ByVal index)
	GetSRCFile=srcFiles(index)
End Function

'Get Target file to be saved
Function GetTARFile(ByVal index)
	GetTARFile=tarFiles(index)
End Function

'Get Total files to be compressed
Function GetTotalFiles()
	GetTotalFiles=FilesCnt
End Function

' Open file
Function OpenFile (Byval file)
	Dim forReading, tStream
	forReading=1
	Set tStream = fso.OpenTextFile(file, forReading)
	OpenFile = tStream.ReadAll()
End Function

' Save file
Function SaveFile(Byval file,Byval content)
	Dim forWriting,tStream
	forWriting=2
	Set tStream=fso.OpenTextFile(file, forWriting,true)
	Call tStream.Write(content)
	Call tStream.Close()
	SaveFile=content
End Function

'Check Folder
Function CheckFolder(path)
	CheckFolder=fso.FolderExists(path)
End Function
