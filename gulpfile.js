var gulp = require('gulp');
var rsync = require('gulp-rsync');

gulp.task('copyModule', function(){
    return gulp.src('module/app/code/local/Kiwee/Chatbot/**')
        .pipe(rsync({
            root: 'module/app/code/local/Kiwee/Chatbot/',
            archive: false,
            emptyDirectories:true,
            destination: '/Users/enzo/workspaces/www/magento1924/public_html/app/code/local/Kiwee/Chatbot/'
        }));
});
gulp.task('copyXml', function(){
    return gulp.src('module/app/etc/modules/Kiwee_Chatbot.xml')
        .pipe(rsync({
            root: 'module/app/etc/modules/',
            archive: false,
            emptyDirectories:true,
            destination: '/Users/enzo/workspaces/www/magento1924/public_html/app/etc/modules/'
        }));
});

gulp.task('default', ['copyModule','copyXml']);
gulp.task('watch', ['copyModule','copyXml'], function () {
    gulp.watch('module/**/*', ['copyModule','copyXml']);
});