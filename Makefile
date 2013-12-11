# Deploy file name
DEPLOY_NAME = mathexpression.zip

# The submodule path
MATHQUILL = ./vendor/mathquill/
# All of the built assets are in the build folder
MATHQUILL_BUILD = ./vendor/mathquill/build

# All of the files that are moved into the main project
RES = ./
RES_JS = ${RES}js/mathquill.min.js
RES_CSS = ${RES}css/mathquill.css
RES_FONT = ${RES}css/font

all: ${RES_JS} ${RES_CSS} ${RES_FONT}

# Copy the JS file
${RES_JS}: ${MATHQUILL_BUILD}/mathquill.js
	cp ${MATHQUILL_BUILD}/mathquill.min.js ${RES_JS}

# Copy the CSS file
${RES_CSS}:  ${MATHQUILL_BUILD}/mathquill.css
	cp ${MATHQUILL_BUILD}/mathquill.css ${RES_CSS}

# Copy the fonts
${RES_FONT}: ${MATHQUILL_BUILD}/font
	cp -r ${MATHQUILL_BUILD}/font ${RES_FONT}

# Build dependency, watches the src folder for changes
${MATHQUILL_BUILD}/mathquill.js: ${MATHQUILL}/src/css/* ${MATHQUILL}/src/* 
	make -C ${MATHQUILL}
	
deploy:
	make clean
	make all
	mkdir mathexpression
	cp -r backup mathexpression
	cp -r css mathexpression
	cp -r db mathexpression
	cp -r js mathexpression
	cp -r lang mathexpression
	cp -r pix mathexpression
	cp -r server mathexpression
	cp -r all_strings.php mathexpression
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
	make -C ${MATHQUILL} clean
	rm -f ${RES_JS}
	rm -f ${RES_CSS}
	rm -f -r ${RES}css/font
	rm -f ${DEPLOY_NAME}
	rm -f -r temp
	rm -f -r mathexpression
