/* This file is part of the YAZ toolkit.
 * Copyright (C) 1995-2009 Index Data.
 * All rights reserved.
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of Index Data nor the names of its contributors
 *       may be used to endorse or promote products derived from this
 *       software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE REGENTS AND CONTRIBUTORS ``AS IS'' AND ANY
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE REGENTS AND CONTRIBUTORS BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF
 * THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

/**
 * \file ill.h
 * \brief ILL Package utilities
 */

#ifndef ILL_H
#define ILL_H

#include <yaz/ill-core.h>
#include <yaz/item-req.h>

YAZ_BEGIN_CDECL

struct ill_get_ctl {
    ODR odr;
    void *clientData;
    const char *(*f)(void *clientData, const char *element);
};
    
YAZ_EXPORT ILL_ItemRequest *ill_get_ItemRequest (
    struct ill_get_ctl *gs, const char *name, const char *sub);

YAZ_EXPORT ILL_Request *ill_get_ILLRequest (
    struct ill_get_ctl *gs, const char *name, const char *sub);

YAZ_EXPORT ILL_Cancel *ill_get_Cancel (
    struct ill_get_ctl *gc, const char *name, const char *sub);

YAZ_EXPORT ILL_APDU *ill_get_APDU (
    struct ill_get_ctl *gc, const char *name, const char *sub);

YAZ_END_CDECL

#endif
/*
 * Local variables:
 * c-basic-offset: 4
 * c-file-style: "Stroustrup"
 * indent-tabs-mode: nil
 * End:
 * vim: shiftwidth=4 tabstop=8 expandtab
 */

