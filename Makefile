DEPLOY_NAME = mathexpression.zip

deploy:
	make clean
	mkdir mathexpression
	cp -r db mathexpression
	cp -r lang mathexpression
	cp -r pix mathexpression
	cp -r server mathexpression
	cp -r configcheck.php mathexpression
	cp -r edit_mathexpression_form.php mathexpression
	cp -r mathexpression.js mathexpression
	cp -r question.php mathexpression
	cp -r questiontype.php mathexpression
	cp -r renderer.php mathexpression
	cp -r settings.php mathexpression
	cp -r styles.css mathexpression
	cp -r version.php mathexpression
	zip -r ${DEPLOY_NAME} mathexpression
	rm -f -r mathexpression

clean:
	rm -f ${DEPLOY_NAME}
	rm -f -r mathexpression
