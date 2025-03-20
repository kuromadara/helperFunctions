if($request->has('identity_proof_file')){
    UploadFiles::saveFile($request->file('identity_proof_file'), 'uploads/'.auth()->id().'/dom-help', $created,'update','identity_proof_file');
}
