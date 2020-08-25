<?php
/**
 * @OA\SecurityScheme(
 *     type="http",
 *     description="Oturum açma jetonu almak için lüfen kullanıcı adı ve şifrenizi giriniz",
 *     name="JSON Web Token(JWT) tabanlı otorum açma",
 *     in="header",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="apiAuth",
 * )
 */
?>